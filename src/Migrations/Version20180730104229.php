<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180730104229 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C4322DF1D37C');
        $this->addSql('DROP INDEX UNIQ_8933C4322DF1D37C ON favoris');
        $this->addSql('ALTER TABLE favoris ADD spot INT NOT NULL, DROP spot_id');
        $this->addSql('ALTER TABLE spot CHANGE user_id user_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE favoris ADD spot_id INT DEFAULT NULL, DROP spot');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C4322DF1D37C FOREIGN KEY (spot_id) REFERENCES spot (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8933C4322DF1D37C ON favoris (spot_id)');
        $this->addSql('ALTER TABLE spot CHANGE user_id user_id INT DEFAULT NULL');
    }
}
