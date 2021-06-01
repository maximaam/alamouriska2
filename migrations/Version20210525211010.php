<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210525211010 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD avatar_name VARCHAR(128) DEFAULT NULL, ADD allow_member_contact TINYINT(1) NOT NULL, ADD allow_post_notification TINYINT(1) NOT NULL, ADD facebook_id VARCHAR(64) NOT NULL, ADD remote_addr VARCHAR(128) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP avatar_name, DROP allow_member_contact, DROP allow_post_notification, DROP facebook_id, DROP remote_addr');
    }
}
