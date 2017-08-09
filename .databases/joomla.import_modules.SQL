\W
DELIMITER $$

DROP PROCEDURE IF EXISTS joomla.import_modules $$
CREATE DEFINER=`root`@`localhost` PROCEDURE joomla.import_modules ()
BEGIN
 declare m_notfound, m_id_module int default 0;

 declare m_id, m_ordering int default 0;
 declare m_title, m_content, m_params text default null;
 declare m_position, m_module varchar(50) default null;
 declare m_published, m_access, m_showtitle tinyint default 0;

 declare m_cursor_modules cursor for
  select id, title, content, ordering, `position`, published, `module`, access, showtitle, params
  from nbmgtu.jos_modules
  where client_id = 0;

 declare continue handler for not found set m_notfound = 1;

 delete from katn3_modules_menu
 where menuid in
 (
  select id
  from katn3_modules
  where client_id = 0
 );

 delete from katn3_modules
 where client_id = 0;

 open m_cursor_modules;
 m_loop_modules:
 loop
  set m_notfound = 0;

  fetch m_cursor_modules
  into m_id, m_title, m_content, m_ordering, m_position, m_published, m_module, m_access, m_showtitle, m_params;

  if m_notfound then
   leave m_loop_modules;
  end if;

  if m_position = "left" then
    set m_position = "position-8";
  elseif m_position = "right" then
    set m_position = "position-7";
  elseif m_position = "top" then
    set m_position = "position-3";
  elseif m_position = "user3" then
    set m_position = "position-1";
  end if;

  if m_module = "mod_mainmenu" then
   set m_module = "mod_menu";
  elseif m_module = "mod_cd_login" then
   set m_module = "mod_login";
  elseif m_module = "mod_poll" then
   iterate m_loop_modules;
  elseif m_module = "mod_liveinternet" then
   iterate m_loop_modules;
--  elseif m_module = "mod_jevents_latest" then
--   iterate m_loop_modules;
--  elseif m_module = "mod_jevents_cal" then
--   iterate m_loop_modules;
  end if;

  insert into katn3_modules
  set title = m_title, content = m_content, ordering = m_ordering, `position` = m_position, published = m_published, `module` = m_module, access = m_access + 1,
      showtitle = m_showtitle, params = m_params, `language` = "*";

  set m_id_module = last_insert_id();

  insert into katn3_modules_menu
  set moduleid = m_id_module, menuid = 0;

 end loop m_loop_modules;
 close m_cursor_modules;

END $$

DELIMITER ;
