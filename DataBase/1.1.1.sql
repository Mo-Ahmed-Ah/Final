CREATE DATABASE IF NOT EXISTS mrbook;
USE mrbook;

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(50) NOT NULL,
  `last_name` VARCHAR(50) NOT NULL,
  `gender` VARCHAR(6) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `phone` CHAR(13) NULL,
  `profile_image` VARCHAR(1000) NULL,
  `cover_image` VARCHAR(1000) NULL,
  `follwers` INT NULL DEFAULT 0,
  `url_address` VARCHAR(100) NULL,
  `created_at` TIMESTAMP NULL DEFAULT NOW(),
  `updated_at` TIMESTAMP NULL DEFAULT NOW() ON UPDATE NOW(),
  PRIMARY KEY (`user_id`),
  INDEX `email` (`email` ASC),
  INDEX `first_name` (`first_name` ASC),
  INDEX `last_name` (`last_name` ASC),
  INDEX `gender` (`gender` ASC),
  INDEX `url_address` (`url_address` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` INT NOT NULL AUTO_INCREMENT,
  `post` TEXT NULL,
  `image` VARCHAR(500) NULL,
  `has_image` TINYINT(1) NOT NULL,
  `likes` INT NULL DEFAULT 0,
  `is_profile_image` TINYINT(1) NULL,
  `is_cover_image` TINYINT(1) NULL,
  `user_id` INT NOT NULL,
  `comments` INT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT NOW(),
  `updated_at` TIMESTAMP NULL DEFAULT NOW() ON UPDATE NOW(),
  PRIMARY KEY (`post_id`),
  INDEX `likes` (`likes` ASC),
  INDEX `comments` (`comments` ASC),
  INDEX `has_image` (`has_image` ASC),
  INDEX `user_id` (`user_id` ASC),
  CONSTRAINT `fk_posts_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `likes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `post_id` INT NOT NULL,
  `is_seet` BIT(1) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `user_id` (`user_id` ASC) ,
  INDEX `fk_likes_posts2_idx` (`post_id` ASC) ,
  CONSTRAINT `fk_likes_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_likes_posts2`
    FOREIGN KEY (`post_id`)
    REFERENCES `posts` (`post_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `comments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `comment_content` VARCHAR(255) NOT NULL,
  `users_user_id` INT NOT NULL,
  `posts_post_id` INT NOT NULL,
  `likes` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_comments_users1_idx` (`users_user_id` ASC),
  INDEX `fk_comments_posts1_idx` (`posts_post_id` ASC),
  CONSTRAINT `fk_comments_users1`
    FOREIGN KEY (`users_user_id`)
    REFERENCES `users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_comments_posts1`
    FOREIGN KEY (`posts_post_id`)
    REFERENCES `posts` (`post_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `comment_likes` (
  `comments_id` INT NOT NULL,
  `users_user_id` INT NOT NULL,
  `is_sit` BIT(1) NOT NULL,
  INDEX `fk_comment_likes_comments1_idx` USING BTREE (`comments_id`),
  INDEX `fk_comment_likes_users1_idx` (`users_user_id` ASC),
  CONSTRAINT `fk_comment_likes_comments1`
    FOREIGN KEY (`comments_id`)
    REFERENCES `comments` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_comment_likes_users1`
    FOREIGN KEY (`users_user_id`)
    REFERENCES `users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `follwers` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `follwer_id` INT NOT NULL,
  `is_seet` BIT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `fk_follwers_users1_idx` (`user_id` ASC),
  INDEX `fk_follwers_users2_idx` (`follwer_id` ASC),
  CONSTRAINT `fk_follwers_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_follwers_users2`
    FOREIGN KEY (`follwer_id`)
    REFERENCES `users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `groups` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `group_name` VARCHAR(100) NOT NULL,
  `description` VARCHAR(255) NULL,
  `group_url` VARCHAR(45) NULL,
  `owner_id` INT NOT NULL,
  `number_of_members` INT NULL,
  `create_at` TIMESTAMP NULL DEFAULT now(),
  `update_at` TIMESTAMP NULL DEFAULT now() ON UPDATE NOW(),
  PRIMARY KEY (`id`),
  INDEX `fk_groups_users1_idx` (`owner_id` ASC) ,
  CONSTRAINT `fk_groups_users1`
    FOREIGN KEY (`owner_id`)
    REFERENCES `users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `users_group` (
  `users_user_id` INT NOT NULL,
  `groups_id` INT NOT NULL,
  `roul` VARCHAR(5) NULL DEFAULT 'user',
  `is_banded` BIT(1) NULL DEFAULT 0,
  `join_at` TIMESTAMP NULL DEFAULT now(),
  INDEX `fk_users_group_users1_idx` (`users_user_id` ASC) ,
  INDEX `fk_users_group_groups1_idx` (`groups_id` ASC) ,
  CONSTRAINT `fk_users_group_users1`
    FOREIGN KEY (`users_user_id`)
    REFERENCES `users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_users_group_groups1`
    FOREIGN KEY (`groups_id`)
    REFERENCES `groups` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `group_posts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `post` TEXT NULL,
  `image` VARCHAR(100) NULL,
  `has_image` BIT(1) NULL DEFAULT 0,
  `comments` INT NULL DEFAULT 0,
  `likes` INT NULL DEFAULT 0,
  `user_id` INT NOT NULL,
  `group_id` INT NOT NULL,
  `create_at` TIMESTAMP NULL DEFAULT now(),
  `update_at` TIMESTAMP NULL DEFAULT now(),
  PRIMARY KEY (`id`),
  INDEX `fk_group_posts_users1_idx` (`user_id` ASC) ,
  INDEX `fk_group_posts_groups1_idx` (`group_id` ASC) ,
  CONSTRAINT `fk_group_posts_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_group_posts_groups1`
    FOREIGN KEY (`group_id`)
    REFERENCES `groups` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `group_post_liks` (
  `user_id` INT NOT NULL,
  `posts_id` INT NOT NULL,
  `is_seet` BIT(1) NULL DEFAULT 1,
  INDEX `fk_group_post_liks_users1_idx` (`user_id` ASC) ,
  INDEX `fk_group_post_liks_group_posts1_idx` (`posts_id` ASC) ,
  CONSTRAINT `fk_group_post_liks_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_group_post_liks_group_posts1`
    FOREIGN KEY (`posts_id`)
    REFERENCES `group_posts` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `group_post_comments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `commentr_content` VARCHAR(100) NULL,
  `user_id` INT NOT NULL,
  `posts_id` INT NOT NULL,
  `likes` VARCHAR(45) NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `fk_group_post_comments_users1_idx` (`user_id` ASC) ,
  INDEX `fk_group_post_comments_group_posts1_idx` (`posts_id` ASC) ,
  CONSTRAINT `fk_group_post_comments_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_group_post_comments_group_posts1`
    FOREIGN KEY (`posts_id`)
    REFERENCES `group_posts` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `g_comment_like` (
  `group_post_comment_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `is_seet` BIT(1) NULL DEFAULT 1,
  INDEX `fk_g_comment_like_group_post_comments1_idx` (`group_post_comment_id` ASC) ,
  INDEX `fk_g_comment_like_users1_idx` (`user_id` ASC) ,
  CONSTRAINT `fk_g_comment_like_group_post_comments1`
    FOREIGN KEY (`group_post_comment_id`)
    REFERENCES `group_post_comments` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_g_comment_like_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

