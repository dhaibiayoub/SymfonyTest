<?php

declare(strict_types=1);

namespace App\Command\Customer;

use App\Provider\CustomerListProvider;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:customer:list',
    description: 'Fetch customers list along with the number of fetches requested.',
)]
class ListCustomersCommand extends Command
{
    public function __construct(
        private CustomerListProvider $customerListProvider,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $results = $this->customerListProvider->provide();

        $io->section("The amount of requests that were made for fetching customers is {$results['requestCount']}.");

        $customers = $results['customers'];
        if ([] === $customers) {
            $io->success('No customer was found.');

            return Command::SUCCESS;
        }

        $io->title('Customers list:');
        $io->table(array_keys($customers[0]), $customers);

        $io->newLine();
        $io->success('Listing completed.');

        return Command::SUCCESS;
    }
}
