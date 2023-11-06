CREATE TABLE Users (
    Id int NOT NULL AUTO_INCREMENT,
    Username varchar(255) NOT NULL,
    Login varchar(255) NOT NULL,
    Password varchar(255) NOT NULL,
    PRIMARY KEY (Id)
);

CREATE TABLE Notes (
    Id int NOT NULL AUTO_INCREMENT,
    Author varchar(255) NOT NULL,
    DataTime DATETIME NOT NULL,
    Title varchar(255) NOT NULL,
    Tags varchar(255),
    Peaple varchar(1023),
    Content varchar(8000),
    PRIMARY KEY (Id)
);
