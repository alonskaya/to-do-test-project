<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190617051451_Init extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription() : string
    {
        return 'Initial migration: creates user_info and to_do_list tables';
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema) : void
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('
            CREATE TABLE IF NOT EXISTS user_info(
                id SERIAL PRIMARY KEY,
                email VARCHAR (320) UNIQUE NOT NULL,
                password VARCHAR (60) NOT NULL,
                last_name VARCHAR (35),
                first_name VARCHAR (35),
                creation_date TIMESTAMP NOT NULL DEFAULT NOW()
            );
        ');
        $this->addSql('
            CREATE TABLE IF NOT EXISTS to_do_list(
                id serial PRIMARY KEY,
                title VARCHAR (128) NOT NULL,
                done BOOLEAN NOT NULL DEFAULT FALSE,
                author INTEGER REFERENCES user_info(id) ON DELETE CASCADE ON UPDATE CASCADE
            );
        ');

        $this->addSql('CREATE UNIQUE INDEX author_title_unique ON to_do_list(author, title)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema) : void
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('ALTER TABLE to_do_list DROP INDEX author_title_unique');
        $this->addSql('DROP TABLE to_do_list');
        $this->addSql('DROP TABLE user_info');
    }
}
