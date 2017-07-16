<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170716234156 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE bookmarks_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE comments_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE bookmarks (id INT NOT NULL, url TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE comments (id INT NOT NULL, bookmark_id INT DEFAULT NULL, text TEXT NOT NULL, ip_address VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5F9E962A92741D25 ON comments (bookmark_id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A92741D25 FOREIGN KEY (bookmark_id) REFERENCES bookmarks (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE comments DROP CONSTRAINT FK_5F9E962A92741D25');
        $this->addSql('DROP SEQUENCE bookmarks_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE comments_id_seq CASCADE');
        $this->addSql('DROP TABLE bookmarks');
        $this->addSql('DROP TABLE comments');
    }
}
