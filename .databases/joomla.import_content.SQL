\W
DELIMITER $$

DROP PROCEDURE IF EXISTS joomla.import_content $$
CREATE DEFINER=`root`@`localhost` PROCEDURE joomla.import_content ()
BEGIN
 declare m_notfound, m_level, m_next, m_id_section, m_id_categories, m_id_content int default 0;

 declare m_section_id, m_categories_id, m_content_id, m_hits, m_ordering, m_frontpage_ordering int default 0;
 declare m_title, m_alias, m_alias_section, m_alias_categories varchar (255) default null;
 declare m_description text default null;
 declare m_published tinyint default 0;
 declare m_introtext, m_fulltext mediumtext default null;
 declare m_created datetime default null;

 declare m_cursor_sections cursor for
  select id, title, alias, description, published
  from nbmgtu.jos_sections;

 declare m_cursor_categories cursor for
  select id, title, alias, description, published
  from nbmgtu.jos_categories
  where `section` = m_section_id;

 declare m_cursor_content cursor for
  select c.id, c.sectionid, c.catid, c.title, c.alias, c.introtext, c.`fulltext`, c.created, c.ordering, c.hits, ifnull(cf.ordering, 0)
  from nbmgtu.jos_content c left join nbmgtu.jos_content_frontpage cf on (cf.content_id = c.id)
  where c.state = 1;

 declare continue handler for not found set m_notfound = 1;

 delete from katn3_categories
 where id != 1 and extension = "com_content";

 delete from katn3_content;

 delete from katn3_content_frontpage;

 create temporary table if not exists _sc2c
 (
  sectionid int unsigned not null,
  catid int unsigned not null,
  id int unsigned not null,
  primary key (sectionid, catid)
 ) engine = memory;

 truncate _sc2c;

 set m_next = ifnull((
  select greatest(max(lft), max(rgt))
  from katn3_categories
 ), 0);

 update katn3_categories
 set lft = 0, rgt = 0
 where id = 1;

 set m_next = m_next + 1;

 insert into katn3_categories
 set id = 2, parent_id = 1, lft = m_next, rgt = m_next + 1, `level` = 1, path = "trash", extension = "com_content", title = "TRASH",
     alias = "trash", published = 1, access = 1, params = "{}", metadata = "{}", created_user_id = 986, `language` = "*";

 insert into _sc2c
 set sectionid = 0, catid = 0, id = 2;

 set m_next = m_next + 1;

 open m_cursor_sections;
 m_loop_sections:
 loop
  set m_notfound = 0;
  set m_level = 1;
  set m_categories_id = 0;

  fetch m_cursor_sections
  into m_section_id, m_title, m_alias_section, m_description, m_published;

  if m_notfound then
   leave m_loop_sections;
  end if;

  set m_next = m_next + 1;

  insert into katn3_categories
  set parent_id = 1, lft = m_next, rgt = 0, `level` = m_level, path = m_alias_section, extension = "com_content", title = m_title,
      alias = m_alias_section, description = m_description,
      published = m_published, access = 1, params = "{}", metadata = "{}", created_user_id = 986, `language` = "*";

  set m_id_section = last_insert_id();

  insert into _sc2c
  set sectionid = m_section_id, catid = m_categories_id, id = m_id_section;

  set m_level = m_level + 1;

  open m_cursor_categories;
  m_loop_categories:
  loop
   set m_notfound = 0;

   fetch m_cursor_categories
   into m_categories_id, m_title, m_alias_categories, m_description, m_published;

   if m_notfound then
    leave m_loop_categories;
   end if;

   set m_next = m_next + 1;

   insert into katn3_categories
   set parent_id = m_id_section, lft = m_next, rgt = 0, `level` = m_level, path = concat(m_alias_section, "/", m_alias_categories), extension = "com_content", title = m_title,
       alias = m_alias_categories, description = m_description,
       published = m_published, access = 1, params = "{}", metadata = "{}", created_user_id = 986, `language` = "*";

   set m_id_categories = last_insert_id();

   insert into _sc2c
   set sectionid = m_section_id, catid = m_categories_id, id = m_id_categories;

   set m_next = m_next + 1;

   update katn3_categories
   set rgt = m_next
   where id = m_id_categories;

  end loop m_loop_categories;
  close m_cursor_categories;

  set m_next = m_next + 1;

  update katn3_categories
  set rgt = m_next
  where id = m_id_section;

 end loop m_loop_sections;
 close m_cursor_sections;


 open m_cursor_content;
 m_loop_content:
 loop
  set m_notfound = 0;

  fetch m_cursor_content
  into m_content_id, m_section_id, m_categories_id, m_title, m_alias, m_introtext, m_fulltext, m_created, m_ordering, m_hits, m_frontpage_ordering;

  if m_notfound then
   leave m_loop_content;
  end if;

  set m_id_categories = ifnull((
   select id
   from _sc2c
   where sectionid = m_section_id and catid = m_categories_id
  ), 0);

  insert into katn3_content
  set title = m_title, alias = m_alias, introtext = m_introtext, `fulltext` = m_fulltext, state = 1, catid = m_id_categories, created = m_created,
      created_by = 986, ordering = m_ordering, access = 1, hits = m_hits, `language` = "*", featured = if(m_frontpage_ordering, 1, 0),
      images = "", urls = "", attribs = "", metakey = "", metadesc = "", metadata = "";

  set m_id_content = last_insert_id();

  if m_frontpage_ordering then

   insert into katn3_content_frontpage
   set content_id = m_id_content, ordering = m_frontpage_ordering;

  end if;

 end loop m_loop_content;
 close m_cursor_content;

 drop temporary table _sc2c;

END $$

DELIMITER ;
