UPDATE wp_options
SET option_value = 'ardeso-fse'
WHERE option_name IN ('template', 'stylesheet');

UPDATE wp_options
SET option_value = 'Ardeso FSE'
WHERE option_name = 'current_theme';

UPDATE wp_options
SET option_value = 'http://localhost:8087'
WHERE option_name IN ('siteurl', 'home');

UPDATE wp_options
SET option_value = 'a:0:{}'
WHERE option_name = 'active_plugins';

DELETE FROM wp_posts
WHERE post_type IN ('wp_template', 'wp_template_part')
AND post_name IN ('front-page', 'header', 'footer');

INSERT INTO wp_posts (
	post_author,
	post_date,
	post_date_gmt,
	post_content,
	post_title,
	post_excerpt,
	post_status,
	comment_status,
	ping_status,
	post_password,
	post_name,
	to_ping,
	pinged,
	post_modified,
	post_modified_gmt,
	post_content_filtered,
	post_parent,
	guid,
	menu_order,
	post_type,
	post_mime_type,
	comment_count
)
SELECT 1, NOW(), UTC_TIMESTAMP(), '', 'Inicio', '', 'publish', 'closed', 'closed', '', 'inicio', '', '', NOW(), UTC_TIMESTAMP(), '', 0, 'http://localhost:8087/inicio/', 0, 'page', '', 0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type = 'page' AND post_name = 'inicio');

INSERT INTO wp_posts (
	post_author,
	post_date,
	post_date_gmt,
	post_content,
	post_title,
	post_excerpt,
	post_status,
	comment_status,
	ping_status,
	post_password,
	post_name,
	to_ping,
	pinged,
	post_modified,
	post_modified_gmt,
	post_content_filtered,
	post_parent,
	guid,
	menu_order,
	post_type,
	post_mime_type,
	comment_count
)
SELECT 1, NOW(), UTC_TIMESTAMP(), '', 'Nosotros', '', 'publish', 'closed', 'closed', '', 'nosotros', '', '', NOW(), UTC_TIMESTAMP(), '', 0, 'http://localhost:8087/nosotros/', 0, 'page', '', 0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type = 'page' AND post_name = 'nosotros');

INSERT INTO wp_posts (
	post_author,
	post_date,
	post_date_gmt,
	post_content,
	post_title,
	post_excerpt,
	post_status,
	comment_status,
	ping_status,
	post_password,
	post_name,
	to_ping,
	pinged,
	post_modified,
	post_modified_gmt,
	post_content_filtered,
	post_parent,
	guid,
	menu_order,
	post_type,
	post_mime_type,
	comment_count
)
SELECT 1, NOW(), UTC_TIMESTAMP(), '', 'Servicios', '', 'publish', 'closed', 'closed', '', 'servicios', '', '', NOW(), UTC_TIMESTAMP(), '', 0, 'http://localhost:8087/servicios/', 0, 'page', '', 0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type = 'page' AND post_name = 'servicios');

INSERT INTO wp_posts (
	post_author,
	post_date,
	post_date_gmt,
	post_content,
	post_title,
	post_excerpt,
	post_status,
	comment_status,
	ping_status,
	post_password,
	post_name,
	to_ping,
	pinged,
	post_modified,
	post_modified_gmt,
	post_content_filtered,
	post_parent,
	guid,
	menu_order,
	post_type,
	post_mime_type,
	comment_count
)
SELECT 1, NOW(), UTC_TIMESTAMP(), '', 'Nuestro Trabajo', '', 'publish', 'closed', 'closed', '', 'nuestro-trabajo', '', '', NOW(), UTC_TIMESTAMP(), '', 0, 'http://localhost:8087/nuestro-trabajo/', 0, 'page', '', 0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type = 'page' AND post_name = 'nuestro-trabajo');

INSERT INTO wp_posts (
	post_author,
	post_date,
	post_date_gmt,
	post_content,
	post_title,
	post_excerpt,
	post_status,
	comment_status,
	ping_status,
	post_password,
	post_name,
	to_ping,
	pinged,
	post_modified,
	post_modified_gmt,
	post_content_filtered,
	post_parent,
	guid,
	menu_order,
	post_type,
	post_mime_type,
	comment_count
)
SELECT 1, NOW(), UTC_TIMESTAMP(), '', 'Contacto', '', 'publish', 'closed', 'closed', '', 'contacto', '', '', NOW(), UTC_TIMESTAMP(), '', 0, 'http://localhost:8087/contacto/', 0, 'page', '', 0
WHERE NOT EXISTS (SELECT 1 FROM wp_posts WHERE post_type = 'page' AND post_name = 'contacto');

UPDATE wp_posts
SET post_status = 'publish'
WHERE post_type = 'page'
AND post_name IN ('inicio', 'nosotros', 'servicios', 'nuestro-trabajo', 'contacto');

DELETE pm
FROM wp_postmeta pm
INNER JOIN wp_posts p ON p.ID = pm.post_id
WHERE pm.meta_key = '_wp_page_template'
AND p.post_type = 'page'
AND p.post_name IN ('nosotros', 'servicios', 'nuestro-trabajo', 'contacto');

INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
SELECT ID, '_wp_page_template', 'page-nosotros'
FROM wp_posts
WHERE post_type = 'page'
AND post_name = 'nosotros';

INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
SELECT ID, '_wp_page_template', 'page-servicios'
FROM wp_posts
WHERE post_type = 'page'
AND post_name = 'servicios';

INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
SELECT ID, '_wp_page_template', 'page-nuestro-trabajo'
FROM wp_posts
WHERE post_type = 'page'
AND post_name = 'nuestro-trabajo';

INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
SELECT ID, '_wp_page_template', 'page-contacto'
FROM wp_posts
WHERE post_type = 'page'
AND post_name = 'contacto';

UPDATE wp_options
SET option_value = 'page'
WHERE option_name = 'show_on_front';

UPDATE wp_options
SET option_value = (SELECT ID FROM wp_posts WHERE post_type = 'page' AND post_name = 'inicio' LIMIT 1)
WHERE option_name = 'page_on_front';
