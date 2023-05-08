create role webfinaluser with password 'webfinal';

create database webfinal;

\c webfinal

create table utilisateur (
    idutilisateur serial primary key,
    nom varchar(50),
    motdepasse varchar(100),
    acces int
);
insert into utilisateur(nom,motdepasse,acces) values('admin','admin',1);
insert into utilisateur(nom,motdepasse,acces) values('utilisateur','utilisateur',0);

create table info (
    idinfo serial primary key,
    titre text,
    dateajout TIMESTAMP default now(),
    contenu text,
    statut int default 0,
    idutilisateur int,
    photo varchar(255),
    foreign key (idutilisateur) references utilisateur(idutilisateur)
);
