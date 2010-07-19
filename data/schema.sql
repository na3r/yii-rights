/**
 * Database schema required by CDbAuthManager.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @since 1.0
 */

drop table if exists AuthAssignment;
drop table if exists AuthItemChild;
drop table if exists AuthItem;

create table AuthItem
(
   name                 varchar(64) not null,
   type                 integer not null,
   description          text,
   bizrule              text,
   data                 text,
   primary key (name)
) type=InnoDB, character set utf8 collate utf8_general_ci;

create table AuthItemChild
(
   parent               varchar(64) not null,
   child                varchar(64) not null,
   primary key (parent,child),
   foreign key (parent) references AuthItem (name) on delete cascade on update cascade,
   foreign key (child) references AuthItem (name) on delete cascade on update cascade
) type=InnoDB, character set utf8 collate utf8_general_ci;

create table AuthAssignment
(
   itemname             varchar(64) not null,
   userid               varchar(64) not null,
   bizrule              text,
   data                 text,
   primary key (itemname,userid),
   foreign key (itemname) references AuthItem (name) on delete cascade on update cascade
) type=InnoDB, character set utf8 collate utf8_general_ci;

/**
 * Necessary roles and relations for the Rights module.
 * If you wish to use a different super user name than 'Admin'
 * change it before running these queries.
 * If you wish to assign the super user role to any other user
 * change the user id in the last query.
 *
 * @author Christoffer Niska
 * @copyright Copyright &copy; 2008 Christoffer Niska
 * @since 0.5
 */

insert into AuthItem (name,type,data) values ('Admin',2,'N;');
insert into AuthItem (name,type,data) values ('Guest',2,'N;');
insert into AuthAssignment (itemname,userid,data) values ('Admin',1,'N;');