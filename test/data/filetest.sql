-- IGNORE THIS COMMENT
CREATE TABLE Persons (
    PersonID int,
    LastName varchar(255),
    FirstName varchar(255),
    Address varchar(255),
    City varchar(255)
);
SELECT * FROM Persons;
DELIMITER ;;
CREATE TRIGGER nome momento evento
ON tabela
FOR EACH ROW
BEGIN
 SELECT DATABASE();
END;;
DELIMITER ;