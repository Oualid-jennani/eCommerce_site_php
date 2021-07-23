create database planetshop;

use planetshop;

create table categorie(
idC smallint auto_increment primary key,
uuidCT nvarchar(36) not null,
CTname nvarchar(255) not null,
idFC smallint,
activation bool default false,
FOREIGN KEY (idFC) REFERENCES  categorie(idC) on delete cascade,
UNIQUE(uuidCT)
);

create table Designation (
idDS int auto_increment primary key,
uuidDS nvarchar(36) not null,
DSname nvarchar(255) not null,
Descript nvarchar(255) not null,
image nvarchar(255),
price float,
Oldprice float,
vues int default 0,
idC smallint not null,
DSquantite int default 0,
activation bool default true,
slider1 bool default false,
slider2 bool default false,
stars tinyint default 4,
dateDS datetime default CURRENT_TIMESTAMP,
FOREIGN KEY (idC) REFERENCES  categorie(idC) on delete cascade,
UNIQUE(uuidDS)
);

create table commandes(
idCM int auto_increment primary key,
dateCom date,
clientMessage text not null,
confirmation bool not null default false
);

create table ligneCommande(
idCM int not null,
DSname nvarchar(255) not null,
CTname nvarchar(255) not null,
qte smallint,
FOREIGN KEY (idCM) REFERENCES  commandes(idCM) on delete cascade
);


create table admin( idAd smallint auto_increment primary key, Adname nvarchar(255) not null,Adpass nvarchar(255) not null);
create table client(idCL smallint auto_increment primary key,CLname nvarchar(255) not null,CLpass nvarchar(255) not null);
insert into admin(Adname,Adpass) values("walid","1234");

insert into categorie(uuidCT,CTname,activation) values(UUID(),"Sliders",true);
insert into categorie(uuidCT,CTname,activation) values(UUID(),"Computers and Laptops",true);
insert into categorie(uuidCT,CTname,activation) values(UUID(),"Component",true);
insert into categorie(uuidCT,CTname,activation) values(UUID(),"Accessories",true);
insert into categorie(uuidCT,CTname,activation) values(UUID(),"Smartphones and Tablets",true);
insert into categorie(uuidCT,CTname) values(UUID(),"Cameras and Photos");
insert into categorie(uuidCT,CTname) values(UUID(),"TV and Audio");
insert into categorie(uuidCT,CTname) values(UUID(),"Car Electronics");


insert into categorie(uuidCT,CTname,idFC,activation) values(UUID(),"Processor",3,true);
insert into categorie(uuidCT,CTname,idFC,activation) values(UUID(),"Motherboard",3,true);
insert into categorie(uuidCT,CTname,idFC,activation) values(UUID(),"Ram",3,true);
insert into categorie(uuidCT,CTname,idFC,activation) values(UUID(),"Solide State Drive",3,true);
insert into categorie(uuidCT,CTname,idFC,activation) values(UUID(),"Hard Drive",3,true);
insert into categorie(uuidCT,CTname,idFC,activation) values(UUID(),"Graphic Card",3,true);
insert into categorie(uuidCT,CTname,idFC,activation) values(UUID(),"Case",3,true);
insert into categorie(uuidCT,CTname,idFC,activation) values(UUID(),"Power Supply",3,true);
insert into categorie(uuidCT,CTname,idFC,activation) values(UUID(),"Watercooling",3,true);

insert into categorie(uuidCT,CTname,idFC,activation) values(UUID(),"Mouse",4,true);
insert into categorie(uuidCT,CTname,idFC,activation) values(UUID(),"Keyboard",4,true);
insert into categorie(uuidCT,CTname,idFC,activation) values(UUID(),"Mousepad",4,true);
insert into categorie(uuidCT,CTname,idFC,activation) values(UUID(),"Headset",4,true);
insert into categorie(uuidCT,CTname,idFC,activation) values(UUID(),"Microphone",4,true);
insert into categorie(uuidCT,CTname,idFC,activation) values(UUID(),"Chair",4,true);
insert into categorie(uuidCT,CTname,idFC,activation) values(UUID(),"Webcam",4,true);
insert into categorie(uuidCT,CTname,idFC,activation) values(UUID(),"Speakers",4,true);
insert into categorie(uuidCT,CTname,idFC,activation) values(UUID(),"Monitor",4,true);
insert into categorie(uuidCT,CTname,idFC,activation) values(UUID(),"Virtual Reality",4,true);
insert into categorie(uuidCT,CTname,idFC,activation) values(UUID(),"Steering Wheel",4,true);
insert into categorie(uuidCT,CTname,idFC,activation) values(UUID(),"Case Fans",4,true);
insert into categorie(uuidCT,CTname,idFC,activation) values(UUID(),"Controller",4,true);


