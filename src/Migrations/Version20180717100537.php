<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180717100537 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE spot ADD user_id INT DEFAULT NULL, ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE spot ADD CONSTRAINT FK_B9327A73A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE spot ADD CONSTRAINT FK_B9327A7312469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_B9327A73A76ED395 ON spot (user_id)');
        $this->addSql('CREATE INDEX IDX_B9327A7312469DE2 ON spot (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE spot DROP FOREIGN KEY FK_B9327A73A76ED395');
        $this->addSql('ALTER TABLE spot DROP FOREIGN KEY FK_B9327A7312469DE2');
        $this->addSql('DROP INDEX IDX_B9327A73A76ED395 ON spot');
        $this->addSql('DROP INDEX IDX_B9327A7312469DE2 ON spot');
        $this->addSql('ALTER TABLE spot DROP user_id, DROP category_id');
    }
}
