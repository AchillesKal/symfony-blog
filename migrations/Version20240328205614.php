<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240328205614 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE blog_post_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tag_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE blog_post (id INT NOT NULL, title VARCHAR(255) NOT NULL, content TEXT DEFAULT NULL, published_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, slug VARCHAR(255) NOT NULL, banner VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BA5AE01D989D9B62 ON blog_post (slug)');
        $this->addSql('COMMENT ON COLUMN blog_post.published_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN blog_post.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN blog_post.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE blog_post_tag (blog_post_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(blog_post_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_2E931ED7A77FBEAF ON blog_post_tag (blog_post_id)');
        $this->addSql('CREATE INDEX IDX_2E931ED7BAD26311 ON blog_post_tag (tag_id)');
        $this->addSql('CREATE TABLE tag (id INT NOT NULL, title VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN tag.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN tag.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
        $this->addSql('ALTER TABLE blog_post_tag ADD CONSTRAINT FK_2E931ED7A77FBEAF FOREIGN KEY (blog_post_id) REFERENCES blog_post (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE blog_post_tag ADD CONSTRAINT FK_2E931ED7BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE blog_post_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tag_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE blog_post_tag DROP CONSTRAINT FK_2E931ED7A77FBEAF');
        $this->addSql('ALTER TABLE blog_post_tag DROP CONSTRAINT FK_2E931ED7BAD26311');
        $this->addSql('DROP TABLE blog_post');
        $this->addSql('DROP TABLE blog_post_tag');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE "user"');
    }
}
