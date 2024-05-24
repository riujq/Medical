<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514154446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE ligne_cmd ADD CONSTRAINT FK_FDB4E3D4CD11A2CF FOREIGN KEY (produits_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE ligne_cmd ADD CONSTRAINT FK_FDB4E3D482EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE produit ADD reference VARCHAR(255) DEFAULT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE sous_category_id sous_category_id INT NOT NULL, CHANGE nom nom LONGTEXT NOT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL, CHANGE prix prix NUMERIC(10, 0) NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27527FEED1 FOREIGN KEY (sous_category_id) REFERENCES sous_category (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27527FEED1 ON produit (sous_category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27527FEED1');
        $this->addSql('DROP INDEX IDX_29A5EC27527FEED1 ON produit');
        $this->addSql('DROP INDEX `primary` ON produit');
        $this->addSql('ALTER TABLE produit DROP reference, CHANGE id id VARCHAR(27) DEFAULT NULL, CHANGE nom nom VARCHAR(190) DEFAULT NULL, CHANGE description description VARCHAR(787) DEFAULT NULL, CHANGE image image VARCHAR(32) DEFAULT NULL, CHANGE prix prix VARCHAR(10) DEFAULT NULL, CHANGE updated_at updated_at VARCHAR(10) DEFAULT NULL, CHANGE sous_category_id sous_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ligne_cmd DROP FOREIGN KEY FK_FDB4E3D4CD11A2CF');
        $this->addSql('ALTER TABLE ligne_cmd DROP FOREIGN KEY FK_FDB4E3D482EA2E54');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C7294869C');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CF675F31B');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DA76ED395');
    }
}
