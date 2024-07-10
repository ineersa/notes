<?php

namespace App\Console\Commands;

use App\Services\NotesService;
use App\Services\UserDatabasesService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TenantQueryHelper extends Command
{
    protected $description = 'Run basic queries on turso tenant db';

    protected $signature = 'tenant:query-helper
                {--tenant= : Tenant to use for database connection (user id)}
                {--tables : Show tables in database}
                {--schema= : Show table schema for table}
                {--queries= : File with queries to execute}
                ';

    public function __construct(
        private UserDatabasesService $userDatabasesService
    )
    {
        parent::__construct();
    }

    public function handle()
    {
        // Validate and get the tenant option
        $tenant = $this->option('tenant');
        if (!$tenant) {
            $this->error('The --tenant option is required.');
            return self::FAILURE;
        }

        $this->userDatabasesService->setupDatabase($tenant);

        if ($this->option('tables')) {
            $this->showTables();
        }

        if ($schema = $this->option('schema')) {
            $this->showTableSchema($schema);
        }

        if ($queriesFile = $this->option('queries')) {
            $this->executeQueriesFromFile($queriesFile);
        }

        if (!$this->option('tables') && !$this->option('schema') && !$this->option('queries')) {
            $this->info('Please provide at least one option: --tables, --schema, or --queries');
            $this->info('Use --help for more information');
        }

//        $model = new \App\Models\Note(["content" => "# Hi\n\ntesting 123 123\n\n[Test](https://test.com)"]);
//        $model->public = false;
//        $model->shared = false;
//        $model->archived = false;
//        $model->metadata = [];
//
//        $model->save();
//        $model->refresh();
//        dd($model);

        return self::SUCCESS;
    }

    protected function showTables()
    {
        $this->info('Showing tables:');
        $tables = DB::connection(UserDatabasesService::CONNECTION_NAME)
            ->getSchemaBuilder()
            ->getTables();
        $this->table(
            ['Tables'],
            array_values($tables)
        );
    }

    protected function showTableSchema($table)
    {
        $this->info("Showing schema for table: {$table}");
        $columns = DB::connection(UserDatabasesService::CONNECTION_NAME)
            ->getSchemaBuilder()
            ->getColumns($table);

        $this->table(
            ['Column', 'Type', 'Collation', 'Nullable', 'Default', 'Auto', 'Comment', 'Generation'],
            array_map(function ($column) {
                return [
                    $column['name'],
                    $column['type'],
                    $column['collation'],
                    $column['nullable'],
                    $column['default'],
                    $column['auto_increment'],
                    $column['comment'],
                    $column['generation'],
                ];
            }, array_values($columns)),
        );

        $indexes = DB::connection(UserDatabasesService::CONNECTION_NAME)
            ->getSchemaBuilder()
            ->getIndexes($table);

        $this->info("Indexes for table: {$table}");
        $this->table(
            ['Index', 'Columns', 'Type', 'Unique', 'Primary'],
            array_map(function ($index) {
                return [
                    $index['name'],
                    implode(", ", $index['columns']),
                    $index['type'],
                    $index['unique'],
                    $index['primary'],
                ];
            }, array_values($indexes)),
        );
    }

    protected function executeQueriesFromFile($file): int
    {
        $file = database_path($file);
        $this->info("Executing queries from file: {$file}");
        $this->output->writeln(str_repeat('-', strlen("Executing queries from file: {$file}")));
        if (!\File::exists($file)) {
            $this->error('File not found.');
            return self::FAILURE;
        }

        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        $processedQueries = $this->processQueries($lines);
        foreach ($processedQueries as $query) {
            $this->info("Query type: " . $query['type']);
            $this->info("Query: ");
            $this->output->writeln(
                $query['query']
            );
            $max = 0;
            foreach (explode("\r\n", $query['query']) as $line) {
                if (strlen($line) > $max) {
                    $max = strlen($line);
                }
            }
            $this->output->writeln(str_repeat('-', $max));

            if ($query['type'] === 'SELECT') {
                $results = \DB::connection(UserDatabasesService::CONNECTION_NAME)
                    ->select($query['query']);
                if (empty($results)) {
                    $this->output->writeln("No results found.");
                    $this->output->writeln(str_repeat('-', strlen("No results found.")));
                    continue;
                }
                $keys = array_keys((array)$results[0]);
                $this->table($keys, array_map(function($item) use ($keys){
                    $row = [];
                    foreach ($keys as $key) {
                        $row[$key] = $item[$key];
                    }
                    return $row;
                }, $results));
                $this->output->writeln(" ");
            } elseif ($query['type'] === 'INSERT') {
                $result = \DB::connection(UserDatabasesService::CONNECTION_NAME)
                    ->insert($query['query']);
                $this->info("Result: " . ($result ? 'OK': 'ERROR'));
                $this->output->writeln(str_repeat('-', $max));
            } elseif ($query['type'] === 'UPDATE') {
                $affected = \DB::connection(UserDatabasesService::CONNECTION_NAME)
                    ->update($query['query']);
                $this->info("Affected rows: " . $affected);
                $this->output->writeln(str_repeat('-', $max));
            } elseif ($query['type'] === 'DELETE') {
                $affected = \DB::connection(UserDatabasesService::CONNECTION_NAME)
                    ->delete($query['query']);
                $this->info("Affected rows: " . $affected);
                $this->output->writeln(str_repeat('-', $max));
            }
        }



        return self::SUCCESS;
    }

    protected function processQueries(array $lines): array
    {
        $queries = [];
        $currentQuery = '';
        $inMultiLineComment = false;

        foreach ($lines as $line) {
            $line = trim($line);

            // Skip empty lines
            if (empty($line)) continue;

            // Handle multi-line comments
            if (str_starts_with($line, '/*')) {
                $inMultiLineComment = true;
                continue;
            }
            if (str_ends_with($line, '*/')) {
                $inMultiLineComment = false;
                continue;
            }
            if ($inMultiLineComment) continue;

            // Skip single-line comments
            if (str_starts_with($line, '--') || str_starts_with($line, '//') || str_starts_with($line, '#')) continue;

            $currentQuery .= "\r\n" . $line;

            // If the line ends with a semicolon, it's the end of a query
            if (str_ends_with($line, ';')) {
                $currentQuery = trim($currentQuery);
                $queryType = $this->getQueryType($currentQuery);

                if ($queryType) {
                    $queries[] = [
                        'query' => $currentQuery,
                        'type' => $queryType
                    ];
                }

                $currentQuery = '';
            }
        }

        return $queries;
    }

    protected function getQueryType(string $query): ?string
    {
        $firstWord = strtoupper(substr($query, 0, strpos($query, ' ')));

        return match ($firstWord) {
            'SELECT' => 'SELECT',
            'INSERT' => 'INSERT',
            'UPDATE' => 'UPDATE',
            'DELETE' => 'DELETE',
            default => null,
        };
    }

}
