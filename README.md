# Dynamic Website | PHP & MySQL

## To do

## SQL tables

```SQL
CREATE TABLE users(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    alias VARCHAR(20) NOT NULL UNIQUE KEY,
    email VARCHAR(50) NOT NULL UNIQUE KEY,
    password VARCHAR(50) NOT NULL,
);
```

```SQL
CREATE TABLE articles(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    headline VARCHAR(40) NOT NULL,
    content VARCHAR(255) NOT NULL,
    publication_date DATETIME NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

```SQL
CREATE TABLE categories(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(30) NOT NULL UNIQUE KEY
);
```

```SQL
CREATE TABLE tags(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(30) NOT NULL UNIQUE KEY
);
```

```SQL
CREATE TABLE article_category(
    article_id INT UNSIGNED NOT NULL,
    category_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (article_id) REFERENCES articles(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);
```

```SQL
CREATE TABLE article_tag(
 article_id INT UNSIGNED NOT NULL,
 tag_id INT UNSIGNED NOT NULL,
 FOREIGN KEY (article_id) REFERENCES articles(id),
 FOREIGN KEY (tag_id) REFERENCES tags(id)
);
```
