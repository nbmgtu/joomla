\W
DELIMITER $$

DROP PROCEDURE IF EXISTS joomla.import_banner $$
CREATE DEFINER=`root`@`localhost` PROCEDURE joomla.import_banner ()
BEGIN
 declare m_notfound, m_id_categories int default 0;

 declare m_categories_id, m_bid, m_clicks, m_ordering int default 0;
 declare m_title, m_alias, m_name varchar (255) default null;
 declare m_imageurl varchar (100) default null;
 declare m_clickurl varchar (200) default null;
 declare m_description, m_custombannercode text default null;
 declare m_published, m_showbanner tinyint default 0;
 declare m_date datetime;

 declare m_cursor_categories cursor for
  select id, title, alias, description, published
  from nbmgtu.jos_categories
  where `section` = "com_banner";

 declare m_cursor_banner cursor for
  select bid, name, alias, clicks, imageurl, clickurl, `date`, showbanner, custombannercode, description, ordering
  from nbmgtu.jos_banner
  where catid = m_categories_id;

 declare continue handler for not found set m_notfound = 1;

 delete from katn3_categories
 where extension = "com_banners";

 delete from katn3_banners;

 open m_cursor_categories;
 m_loop_categories:
 loop
  set m_notfound = 0;

  fetch m_cursor_categories
  into m_categories_id, m_title, m_alias, m_description, m_published;

  if m_notfound then
   leave m_loop_categories;
  end if;

  insert into katn3_categories
  set parent_id = 1, lft = 0, rgt = 1, `level` = 1, path = m_alias, extension = "com_banners", title = m_title,
      alias = m_alias, description = m_description,
      published = m_published, access = 1, params = "{}", metadata = "{}", created_user_id = 986, `language` = "*";

  set m_id_categories = last_insert_id();

  open m_cursor_banner;
  m_loop_banner:
  loop
   set m_notfound = 0;

   fetch m_cursor_banner
   into m_bid, m_name, m_alias, m_clicks, m_imageurl, m_clickurl, m_date, m_showbanner, m_custombannercode, m_description, m_ordering;

   if m_notfound then
    leave m_loop_banner;
   end if;

   insert into katn3_banners
   set id = m_bid, name = m_name, alias = m_alias, clicks = m_clicks, clickurl = m_clickurl, state = if(m_showbanner, 1, 2), catid = m_id_categories,
       description = m_description, custombannercode = m_custombannercode, created = m_date, ordering = m_ordering, `language` = "*", params = concat("{\"imageurl\":\"images\/banners\/", m_imageurl, "\"}"), metakey = "";

  end loop m_loop_banner;
  close m_cursor_banner;

 end loop m_loop_categories;
 close m_cursor_categories;

END $$

DELIMITER ;
