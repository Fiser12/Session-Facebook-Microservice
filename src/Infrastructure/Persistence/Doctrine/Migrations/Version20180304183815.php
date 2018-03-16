<?php declare(strict_types = 1);

namespace Session\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180304183815 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE session_user (id CHAR(36) NOT NULL COMMENT \'(DC2Type:user_id)\', created_on DATETIME NOT NULL, last_login DATETIME DEFAULT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:user_roles)\', updated_on DATETIME NOT NULL, confirmationToken_token VARCHAR(36) DEFAULT NULL, confirmationToken_created_on DATETIME DEFAULT NULL, email VARCHAR(60) NOT NULL, invitationToken_token VARCHAR(36) DEFAULT NULL, invitationToken_created_on DATETIME DEFAULT NULL, password VARCHAR(60) DEFAULT NULL, salt VARCHAR(60) DEFAULT NULL, rememberPasswordToken_token VARCHAR(36) DEFAULT NULL, rememberPasswordToken_created_on DATETIME DEFAULT NULL, facebook_id_id VARCHAR(255) NOT NULL, facebook_access_token_token VARCHAR(255) NOT NULL, full_name_first_name_firstName VARCHAR(255) NOT NULL, full_name_last_name_lastName VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session_users_followed (user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:user_id)\', user_followed_id CHAR(36) NOT NULL COMMENT \'(DC2Type:user_id)\', INDEX IDX_A10B3F6BA76ED395 (user_id), INDEX IDX_A10B3F6B704D3985 (user_followed_id), PRIMARY KEY(user_id, user_followed_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE session_users_followed ADD CONSTRAINT FK_A10B3F6BA76ED395 FOREIGN KEY (user_id) REFERENCES session_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE session_users_followed ADD CONSTRAINT FK_A10B3F6B704D3985 FOREIGN KEY (user_followed_id) REFERENCES session_user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE session_users_followed DROP FOREIGN KEY FK_A10B3F6BA76ED395');
        $this->addSql('ALTER TABLE session_users_followed DROP FOREIGN KEY FK_A10B3F6B704D3985');
        $this->addSql('DROP TABLE session_user');
        $this->addSql('DROP TABLE session_users_followed');
    }
}
