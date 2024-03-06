<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220133009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponses_create_by_users CHANGE id_question id_question_id INT NOT NULL');
        $this->addSql('ALTER TABLE reponses_create_by_users ADD CONSTRAINT FK_F2B99BD96353B48 FOREIGN KEY (id_question_id) REFERENCES question_create_by_users (id)');
        $this->addSql('CREATE INDEX IDX_F2B99BD96353B48 ON reponses_create_by_users (id_question_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponses_create_by_users DROP FOREIGN KEY FK_F2B99BD96353B48');
        $this->addSql('DROP INDEX IDX_F2B99BD96353B48 ON reponses_create_by_users');
        $this->addSql('ALTER TABLE reponses_create_by_users CHANGE id_question_id id_question INT NOT NULL');
    }
}
