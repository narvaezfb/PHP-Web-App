/*Name: Fabian Narvaez
date: 2020-09-12
course code: wedb 3201 */
CREATE EXTENSION  IF NOT EXISTS pgcrypto;
DROP SEQUENCE IF EXISTS users_id_seq;
CREATE SEQUENCE users_id_seq start 1000;
DROP TABLE IF EXISTS users;
Create Table users (
	id integer primary key  default nextval('users_id_seq'),
	email varchar (255) not null unique,
	password varchar(255) not null,
	First_Name varchar(128),
	Last_Name varchar (128),
	Created timestamp not null,
	Last_time_user_logged timestamp,
	Phone_extension varchar (15),
	User_type varchar(2)
);

insert into users (email, password, First_Name,Last_Name,Created,Last_time_user_logged,Phone_extension,User_type) values
('narvaezfb4@hotmail.com',crypt('somepassword', gen_salt('bf')),'Fabian','Narvaez', '2019-09-16 19:10:23', '2020-09-17 20:18:56','6475635180','s');

insert into users (email, password, First_Name,Last_Name,Created,Last_time_user_logged,Phone_extension,User_type) values
('fabian123@hotmail.com',crypt('ecuador', gen_salt('bf')),'Mauricio','Goyes', '2019-09-17 19:10:23', '2020-09-18 20:18:56','6475635170','s');

insert into users (email, password, First_Name,Last_Name,Created,Last_time_user_logged,Phone_extension,User_type) values
('monica@hotmail.com',crypt('Toronto', gen_salt('bf')),'Monica','Huilcapi', '2019-09-18 19:10:23', '2020-09-19 20:18:56','6475635100','s');


INSERT INTO users(email, password, First_Name,Last_Name,Created,Last_time_user_logged,Phone_extension,User_type)
        VALUES (
        'Ramiro@hotmail.com',
        crypt('ramiro', gen_salt('bf')),
        'Ramiro',
        'Mendez',
        '2020-10-16',
        '2020-10-16',
        '112345532',
        's'
        );
INSERT INTO users(email, password, First_Name,Last_Name,Created,Last_time_user_logged,Phone_extension,User_type)
        VALUES (
        'berlyn@hotmail.com',
        crypt('berlyn19', gen_salt('bf')),
        'Berlyn',
        'French',
        '2020-10-16',
        '2020-10-16',
        '6476789012',
        's'
        );
INSERT INTO users(email, password, First_Name,Last_Name,Created,Last_time_user_logged,Phone_extension,User_type)
        VALUES (
        'james@gmail.com',
        crypt('12345', gen_salt('bf')),
        'james',
        'smart',
        '2020-10-16',
        '2020-10-16',
        '12345',
        's'
        );
INSERT INTO users(email, password, First_Name,Last_Name,Created,Last_time_user_logged,Phone_extension,User_type)
        VALUES (
        'Peter@outlook.com',
        crypt('peter', gen_salt('bf')),
        'peter',
        'griffin',
        '2020-10-16',
        '2020-10-16',
        '1234567654',
        's'
        );
INSERT INTO users(email, password, First_Name,Last_Name,Created,Last_time_user_logged,Phone_extension,User_type)
        VALUES (
        'steven@gmail.com',
        crypt('steven', gen_salt('bf')),
        'steven',
        'smith',
        '2020-10-16',
        '2020-10-16',
        '12345678',
        's'
        );
INSERT INTO users(email, password, First_Name,Last_Name,Created,Last_time_user_logged,Phone_extension,User_type)
        VALUES (
        'holguer@hotmail.com',
        crypt('holguer', gen_salt('bf')),
        'holguer',
        'vallejo',
        '2020-10-17',
        '2020-10-17',
        '123456789',
        's'
        );
INSERT INTO users(email, password, First_Name,Last_Name,Created,Last_time_user_logged,Phone_extension,User_type)
        VALUES (
        'paty@hotmail.com',
        crypt('paty', gen_salt('bf')),
        'paty',
        'array',
        '2020-10-17',
        '2020-10-17',
        '1827633',
        's'
        );

INSERT INTO users(email, password, First_Name,Last_Name,Created,Last_time_user_logged,Phone_extension,User_type)
        VALUES (
        'juan@hotmail.com',
        crypt('ajaj', gen_salt('bf')),
        'juan',
        'jaja',
        '2020-10-18',
        '2020-10-18',
        '9191',
        's'
        );

INSERT INTO users(email, password, First_Name,Last_Name,Created,Last_time_user_logged,Phone_extension,User_type)
        VALUES (
        'monica16@hotmail.com',
        crypt('chelita', gen_salt('bf')),
        'patricia',
        'huilcapi',
        '2020-10-19',
        '2020-10-19',
        '91817161',
        's'
        );

INSERT INTO users(email, password, First_Name,Last_Name,Created,Last_time_user_logged,Phone_extension,User_type)
        VALUES (
        'aviroy@gmail.com',
        crypt('kaka', gen_salt('bf')),
        'hah',
        'haha',
        '2020-10-19',
        '2020-10-19',
        '818717',
        's'
        );

INSERT INTO users(email, password, First_Name,Last_Name,Created,Last_time_user_logged,Phone_extension,User_type)
        VALUES (
        'sara@gmail.com',
        crypt('kska', gen_salt('bf')),
        'iaka',
        'ksks',
        '2020-10-19',
        '2020-10-19',
        '0291',
        's'
        );

INSERT INTO users(email, password, First_Name,Last_Name,Created,Last_time_user_logged,Phone_extension,User_type)
        VALUES (
        'benito@gmail.com',
        crypt('benito', gen_salt('bf')),
        'benito',
        'juan',
        '2020-10-19',
        '2020-10-19',
        '123456',
        's'
        );

--create table clients 
DROP SEQUENCE IF EXISTS clients_id_seq;
CREATE SEQUENCE clients_id_seq start 1000;
DROP TABLE IF EXISTS clients;
Create Table clients (
	id integer primary key default nextval('clients_id_seq') ,
	clientEmail varchar (255) not null unique,
	clientFirstName varchar(128),
	clientLastName varchar (128),
	clientPhoneExtension varchar (15),
	salespersonAssociated integer not null REFERENCES users (id),
        img_dir varchar (255)
);


        --create table calls 
DROP SEQUENCE IF EXISTS calls_id_seq;
CREATE SEQUENCE calls_id_seq start 1000;
DROP TABLE IF EXISTS calls;
Create Table calls (
id integer primary key default nextval('calls_id_seq') ,
clientId integer  not null REFERENCES clients (id),
timeOfTheCall varchar(128)
);


        