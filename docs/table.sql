CREATE TABLE `idus`.`member` (
    `seq` INT(11) NOT NULL AUTO_INCREMENT COMMENT '멤버SEQ',
    `userName` VARCHAR(50) NOT NULL COMMENT '이름',
    `nickname` VARCHAR(50) NOT NULL COMMENT '넥네임',
    `passwd` VARCHAR(100) NOT NULL COMMENT '비밀번호',
    `phone` VARCHAR(100) NOT NULL COMMENT '전화번호',
    `email` VARCHAR(150) NOT NULL COMMENT '이메일',
    `gender` CHAR(1) NULL COMMENT '성별',
    `lastLoginDt` DATETIME NOT NULL,
    `regDt` DATETIME NOT NULL,
    PRIMARY KEY (`seq`)
) ENGINE = InnoDB;

CREATE INDEX serchIndex ON member (userName, email);