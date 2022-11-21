<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221121104311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE app (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, identificator VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, score DOUBLE PRECISION NOT NULL, icon_url VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_C96E70CFB403FBF1 (identificator), INDEX IDX_C96E70CF12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, identificator VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_ECC796CB403FBF1 (identificator), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE app ADD CONSTRAINT FK_C96E70CF12469DE2 FOREIGN KEY (category_id) REFERENCES app_category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app DROP FOREIGN KEY FK_C96E70CF12469DE2');
        $this->addSql('DROP TABLE app');
        $this->addSql('DROP TABLE app_category');
    }
}
