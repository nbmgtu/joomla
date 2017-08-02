\W
DELIMITER $$

DROP PROCEDURE IF EXISTS joomla.import_menu $$
CREATE DEFINER=`root`@`localhost` PROCEDURE joomla.import_menu ()
BEGIN
 declare m_notfound, m_id_menutype, m_id_menu, m_id_component int default 0;

 declare m_menutype_id, m_menu_id, m_componentid, m_ordering, m_home int default 0;
 declare m_menutype varchar (75) default null;
 declare m_name, m_alias, m_title, m_description varchar (255) default null;
 declare m_type, m_option varchar (50) default null;
 declare m_link, m_params text default null;
 declare m_published tinyint default 0;

 declare m_cursor_menutypes cursor for
  select id, menutype, title, description
  from nbmgtu.jos_menu_types;

 declare m_cursor_menu cursor for
  select id, name, md5(rand()) as alias, link, `type`, published, componentid, ordering, params, home
  from nbmgtu.jos_menu
  where menutype = m_menutype;

 declare continue handler for not found set m_notfound = 1;

 delete from katn3_menu_types
 where client_id = 0;

 delete from katn3_menu
 where client_id = 0 and id != 1;

 open m_cursor_menutypes;
 m_loop_menutypes:
 loop
  set m_notfound = 0;

  fetch m_cursor_menutypes
  into m_menutype_id, m_menutype, m_title, m_description;

  if m_notfound then
   leave m_loop_menutypes;
  end if;

  insert into katn3_menu_types
  set menutype = m_menutype, title = m_title, description = m_description;

  set m_id_menutype = last_insert_id();

  open m_cursor_menu;
  m_loop_menu:
  loop
   set m_notfound = 0;

   fetch m_cursor_menu
   into m_menu_id, m_name, m_alias, m_link, m_type, m_published, m_componentid, m_ordering, m_params, m_home;

   if m_notfound then
    leave m_loop_menu;
   end if;

   if m_link = "index.php?option=com_content&view=frontpage" then
    set m_link = "index.php?option=com_content&view=featured";
   end if;

   set m_id_component = 0;

   if m_componentid then

    set m_option = (
     select `option`
     from nbmgtu.jos_components
     where id = m_componentid
    );

    if m_option = "com_user" then
     set m_option = "com_users";
    end if;

    if m_option is null or m_option != "com_weblinks" then

     set m_id_component = (
      select extension_id
      from katn3_extensions
      where name = m_option
     );

     if m_id_component is null then
      select "not_found", m_option, m_componentid;
      iterate m_loop_menu;
     end if;

    end if;

   end if;

   insert into katn3_menu
   set menutype = m_menutype, title = m_name, alias = m_alias, path = "", link = m_link, `type` = m_type, published = m_published, parent_id = 1, `level` = 1,
       component_id = m_id_component, access = 1, img = "", params = "", lft = 0, rgt = 1, home = m_home, `language` = "*";

   set m_id_menu = last_insert_id();

  end loop m_loop_menu;
  close m_cursor_menu;

 end loop m_loop_menutypes;
 close m_cursor_menutypes;

END $$

DELIMITER ;
