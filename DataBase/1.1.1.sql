-- Create the database if it doesn't exist
drop database mrbook;
CREATE DATABASE IF NOT EXISTS mrbook;

-- Use the database
USE mrbook;

-- Create users table
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
  `followers` INT NULL DEFAULT 0,
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

-- Create posts table
CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` INT NOT NULL AUTO_INCREMENT,
  `post` TEXT NULL,
  `image` VARCHAR(500) NULL,
  `has_image` TINYINT(1) NOT NULL DEFAULT 0,
  `likes` INT NULL DEFAULT 0,
  `is_profile_image` TINYINT(1) NULL DEFAULT 0,
  `is_cover_image` TINYINT(1) NULL DEFAULT 0,
  `user_id` INT NOT NULL,
  `comments` INT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT NOW(),
  `updated_at` TIMESTAMP NULL DEFAULT NOW() ON UPDATE NOW(),
  PRIMARY KEY (`post_id`),
  INDEX `likes` (`likes` ASC),
  INDEX `comments` (`comments` ASC),
  INDEX `has_image` (`has_image` ASC),
  INDEX `user_id` (`user_id` ASC),
  CONSTRAINT `fk_posts_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Create likes table
CREATE TABLE IF NOT EXISTS `likes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `post_id` INT NOT NULL,
  `is_seen` BIT(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`id`),
  INDEX `user_id` (`user_id` ASC),
  INDEX `post_id` (`post_id` ASC),
  CONSTRAINT `fk_likes_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_likes_posts`
    FOREIGN KEY (`post_id`)
    REFERENCES `posts` (`post_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Create comments table
CREATE TABLE IF NOT EXISTS `comments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `comment_content` VARCHAR(255) NOT NULL,
  `user_id` INT NOT NULL,
  `post_id` INT NOT NULL,
  `likes` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `user_id` (`user_id` ASC),
  INDEX `post_id` (`post_id` ASC),
  CONSTRAINT `fk_comments_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_comments_posts`
    FOREIGN KEY (`post_id`)
    REFERENCES `posts` (`post_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Create comment_likes table
CREATE TABLE IF NOT EXISTS `comment_likes` (
  `comment_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `is_seen` BIT(1) NOT NULL DEFAULT b'1',
  INDEX `comment_id` (`comment_id` ASC),
  INDEX `user_id` (`user_id` ASC),
  CONSTRAINT `fk_likes_comments_id`
    FOREIGN KEY (`comment_id`)
    REFERENCES `comments`(`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_likes_users_id`
    FOREIGN KEY (`user_id`)
    REFERENCES `users`(`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Create followers table
CREATE TABLE IF NOT EXISTS `followers` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `follower_id` INT NOT NULL,
  `is_seen` BIT(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  INDEX `user_id` (`user_id` ASC),
  INDEX `follower_id` (`follower_id` ASC),
  CONSTRAINT `fk_followers_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_followers_follower`
    FOREIGN KEY (`follower_id`)
    REFERENCES `users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Create groups table
CREATE TABLE IF NOT EXISTS `groups` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `group_name` VARCHAR(100) NOT NULL,
  `image` VARCHAR(100) NULL,
  `description` VARCHAR(255) NULL,
  `group_url` VARCHAR(100) NULL,
  `owner_id` INT NOT NULL,
  `number_of_members` INT NULL DEFAULT 1,
  `create_at` TIMESTAMP NULL DEFAULT now(),
  `update_at` TIMESTAMP NULL DEFAULT now(),
  PRIMARY KEY (`id`),
  INDEX `fk_groups_users1_idx` (`owner_id` ASC) ,
  CONSTRAINT `fk_groups_users1`
    FOREIGN KEY (`owner_id`)
    REFERENCES `users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- Create users_group table
CREATE TABLE IF NOT EXISTS `users_group` (
  `user_id` INT NOT NULL,
  `group_id` INT NOT NULL,
  `role` VARCHAR(5) NULL DEFAULT 'user',
  `is_banned` BIT(1) NULL DEFAULT b'0',
  `joined_at` TIMESTAMP NULL DEFAULT NOW(),
  INDEX `user_id` (`user_id` ASC),
  INDEX `group_id` (`group_id` ASC),
  CONSTRAINT `fk_users_group_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_users_group_groups`
    FOREIGN KEY (`group_id`)
    REFERENCES `groups` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Create group_posts table
CREATE TABLE IF NOT EXISTS `group_posts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `post` TEXT NULL,
  `image` VARCHAR(100) NULL,
  `is_cover_image` VARCHAR(100) NULL DEFAULT 0,
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

-- Create group_post_likes table
CREATE TABLE IF NOT EXISTS `group_post_likes` (
  `user_id` INT NOT NULL,
  `post_id` INT NOT NULL,
  `is_seen` BIT(1) NULL DEFAULT b'1',
  INDEX `user_id` (`user_id` ASC),
  INDEX `post_id` (`post_id` ASC),
  CONSTRAINT `fk_group_post_likes_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_group_post_likes_group_posts`
    FOREIGN KEY (`post_id`)
    REFERENCES `group_posts` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Create group_post_comments table
CREATE TABLE IF NOT EXISTS `group_post_comments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `comment_content` VARCHAR(100) NULL,
  `user_id` INT NOT NULL,
  `post_id` INT NOT NULL,
  `likes` INT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `user_id` (`user_id` ASC),
  INDEX `post_id` (`post_id` ASC),
  CONSTRAINT `fk_group_post_comments_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_group_post_comments_group_posts`
    FOREIGN KEY (`post_id`)
    REFERENCES `group_posts` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Create group_comment_likes table
CREATE TABLE IF NOT EXISTS `group_comment_likes` (
  `comment_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `is_seen` BIT(1) NULL DEFAULT b'1',
  INDEX `comment_id` (`comment_id` ASC),
  INDEX `user_id` (`user_id` ASC),
  CONSTRAINT `fk_group_comment_likes_comments`
    FOREIGN KEY (`comment_id`)
    REFERENCES `group_post_comments` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_group_comment_likes_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB;
