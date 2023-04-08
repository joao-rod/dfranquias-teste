<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230407235544 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cattle ADD week_portion DOUBLE PRECISION NOT NULL, ADD cattle_weight DOUBLE PRECISION NOT NULL, DROP portion_week, DROP weight_cattle');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cattle ADD portion_week DOUBLE PRECISION NOT NULL, ADD weight_cattle DOUBLE PRECISION NOT NULL, DROP week_portion, DROP cattle_weight');
    }
}
