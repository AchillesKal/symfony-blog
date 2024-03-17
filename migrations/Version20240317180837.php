<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240317180837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE blog_post (id INT NOT NULL, title VARCHAR(255) NOT NULL, content TEXT DEFAULT NULL, published_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN blog_post.published_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN blog_post.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN blog_post.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE tag (id INT NOT NULL, title VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN tag.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN tag.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE tag_blog_post (tag_id INT NOT NULL, blog_post_id INT NOT NULL, PRIMARY KEY(tag_id, blog_post_id))');
        $this->addSql('CREATE INDEX IDX_AB6DDA3ABAD26311 ON tag_blog_post (tag_id)');
        $this->addSql('CREATE INDEX IDX_AB6DDA3AA77FBEAF ON tag_blog_post (blog_post_id)');
        $this->addSql('ALTER TABLE tag_blog_post ADD CONSTRAINT FK_AB6DDA3ABAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tag_blog_post ADD CONSTRAINT FK_AB6DDA3AA77FBEAF FOREIGN KEY (blog_post_id) REFERENCES blog_post (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE tag_blog_post DROP CONSTRAINT FK_AB6DDA3ABAD26311');
        $this->addSql('ALTER TABLE tag_blog_post DROP CONSTRAINT FK_AB6DDA3AA77FBEAF');
        $this->addSql('DROP TABLE blog_post');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_blog_post');
    }
}
