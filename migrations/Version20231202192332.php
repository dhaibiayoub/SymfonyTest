<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231202192332 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creating table for saving weither calls';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE weather (id INT AUTO_INCREMENT NOT NULL, city VARCHAR(255) NOT NULL, city_local_time DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', temperature DOUBLE PRECISION NOT NULL, feelslike DOUBLE PRECISION NOT NULL, icon VARCHAR(255) DEFAULT NULL, wind_speed DOUBLE PRECISION NOT NULL, humidity INT NOT NULL, uv DOUBLE PRECISION NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE weather');
    }
}
