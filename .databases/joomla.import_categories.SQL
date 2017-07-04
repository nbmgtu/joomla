\W
DELIMITER $$

DROP PROCEDURE IF EXISTS joomla.import_categories $$
CREATE DEFINER=`root`@`localhost` PROCEDURE joomla.import_categories ()
BEGIN
 declare m_notfound, m_level, m_next, m_id_section, m_id_categories int;

 declare m_section_id, m_categories_id int;
 declare m_title, m_alias_section, m_alias_categories varchar (255);
 declare m_description text;
 declare m_access, m_published tinyint;

 declare m_cursor_sections cursor for
  select id, title, alias, description, published, 1 as access
  from nbmgtu.jos_sections;

 declare m_cursor_categories cursor for
  select id, title, alias, description, published, 1 as access
  from nbmgtu.jos_categories
  where `section` = m_section_id;

 declare continue handler for not found set m_notfound = 1;


 delete from katn3_categories
 where id != 1;

 set m_next = ifnull((
  select greatest(max(lft), max(rgt))
  from katn3_categories
 ), 0);

 open m_cursor_sections;
 m_loop_sections:
 loop
  set m_notfound = 0;
  set m_level = 1;

  fetch m_cursor_sections
  into m_section_id, m_title, m_alias_section, m_description, m_published, m_access;

  if m_notfound then
   leave m_loop_sections;
  end if;

  set m_next = m_next + 1;

  insert into katn3_categories
  set parent_id = 1, lft = m_next, rgt = 0, `level` = m_level, path = m_alias_section, extension = "com_content", title = m_title,
      alias = m_alias_section, description = m_description,
      published = m_published, access = m_access, params = "{}", metadata = "{}", created_user_id = 986, `language` = "*";

  set m_id_section = last_insert_id();

  set m_level = m_level + 1;

  open m_cursor_categories;
  m_loop_categories:
  loop
   set m_notfound = 0;

   fetch m_cursor_categories
   into m_categories_id, m_title, m_alias_categories, m_description, m_published, m_access;

   if m_notfound then
    leave m_loop_categories;
   end if;

   set m_next = m_next + 1;

   insert into katn3_categories
   set parent_id = m_id_section, lft = m_next, rgt = 0, `level` = m_level, path = concat(m_alias_section, "/", m_alias_categories), extension = "com_content", title = m_title,
       alias = m_alias_categories, description = m_description,
       published = m_published, access = m_access, params = "{}", metadata = "{}", created_user_id = 986, `language` = "*";

   set m_id_categories = last_insert_id();

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

END $$

DELIMITER ;
