<?php
/*  Copyright 2010 - 2014  Andres Ramiro Molina Romero  (email : amolina@andresmolina.org twitter: @amolinachile)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
/*
Plugin Name: Wordpress Flash Page Flip
Plugin URI: http://andresmolina.org/proyectos/wordpress-flash-page-flip-crea-tu-papel-digital-en-pocos-minutos/
Description: Create a Flash Page Flip(Magazines, catalogs, etc) / Crea Revistas digitales
Version:1.0.8
Author: Andrés Molina @amolinachile
Author URI: http://andresmolina.org
License: GPL2
*/
include("config.php");
if ( preg_match('#'.basename(__FILE__).'#', $_SERVER['PHP_SELF']) ) { die(__('You are not allowed to call this page directly.', $wpfpf_context)); }
// Hook for adding admin menus
add_action('admin_menu', 'wpfpf_add_pages');
// action function for above hook
function wpfpf_add_pages() {
Global $wpfpf_context;
    // $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
    // Add a new top-level menu (ill-advised):
    add_menu_page(__('Wordpress Flash PageFlip',$wpfpf_context), __('Flash Page Flip',$wpfpf_context), 'manage_options', 'wp-flash-page-flip', 'wpfpf_toplevel_page',WP_PLUGIN_URL."/wordpress-flash-page-flip/images/flipbook.png" );
//$parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function

    // Add a submenu to the custom top-level menu:
    add_submenu_page('wp-flash-page-flip', __('Configuracion de Wordpress Flash Page Flip',$wpfpf_context), __('Configuracion',$wpfpf_context), 'manage_options', 'wp-flash-page-flip/configuracion', 'wpfpf_sublevel_page');

    // Add a second submenu to the custom top-level menu:
    add_submenu_page('wp-flash-page-flip', __('Acerca de Wordpress Flash Page Flip',$wpfpf_context), __('About',$wpfpf_context), 'manage_options', 'wp-flash-page-flip/acerca-de', 'wpfpf_acercade');

if(!file_exists(dirname(__FILE__)."/base.zip")){
 add_submenu_page('wp-flash-page-flip', __('Instalar archivo base',$wpfpf_context), __('Instalar Archivo base',$wpfpf_context), 'manage_options', 'wp-flash-page-flip/instalar-archivo-base', 'wpfpf_archivobase');
	
}
}

// wpfpf_toplevel_page() displays the page content for the custom Test Toplevel menu
function wpfpf_toplevel_page() {
Global $wpfpf_thumb_option,$wpfpf_full_name,$wpfpf_lnk_target, $wpfpf_context, $wpfpf_nombrecorto, $wpfpf_width, $wpfpf_height, $wpfpf_bgcolor, $wpfpf_loadercolor, $wpfpf_panelcolor, $wpfpf_buttoncolor, $wpfpf_textcolor, $wpfpf_folder_name;

if(file_exists(dirname(__FILE__)."/base.zip")){
$existebase= __("Tienes instalado el archivo Base.",$wpfpf_context);	
}else{
$existebase=__("Error: Debes subir el archivo base.zip en esta ruta: ".dirname(__FILE__),$wpfpf_context);
}

if(strlen(get_option($wpfpf_nombrecorto."paginaprincipal"))>0){
$page_dataz = get_page(get_option($wpfpf_nombrecorto."paginaprincipal"));
$existepaginabase=$page_dataz->post_title;
}else{
$existepaginabase=__("Debes elejir la pagina base donde publicaras los Page Flip",$wpfpf_context);
}
echo '<div class="wrap">';

    echo "<h2>" . __( 'Administracion de Wordpress Page Flip Book', $wpfpf_context ) . "</h2>";
    echo  '
			<table class="widefat fixed" cellspacing="0" style="width:500px;">
				<thead>
					<tr class="thead">
						<th scope="col" class="" style="">'. __( 'Chequeo del Plugin', $wpfpf_context ).'</th>
					</tr>
				</thead>
				<tbody id="users" class="">
					<tr id="user-1" class="alternate">
						<td class="">
							<ul class="settings">
			      			  <li>' . __('Flip Book Base:', $wpfpf_context) . ' : <span>' . $existebase . '</span></li>
							  <li>' . __('Pagina Base', $wpfpf_context) . ' : <span>' . $existepaginabase. '</span></li>
							  <li>_____________________________________________________________________________ </li>
							  <li>' . __('Las siguiente opciones se cambian en el archivo', $wpfpf_context) . ' : <span> config.php</span></li>
							  <li>' . __('Ancho', $wpfpf_context) . ' : <span>' . $wpfpf_width . '</span></li>
							  <li>' . __('Alto', $wpfpf_context) . ' : <span>' . $wpfpf_height . '</span></li>
							  <li>' . __('Variable Option con el tamano del Thumbnail', $wpfpf_context) . ' : <span>' . $wpfpf_thumb_option . '</span></li>
							  <li>' . __('Target(para los thumnails de la pagina principal)', $wpfpf_context) . ' : <span>' . $wpfpf_lnk_target . '</span></li>
							  <li>' . __('Color de fondo', $wpfpf_context) . ' : <span>' . $wpfpf_bgcolor . '</span></li>
							  <li>' . __('Color del cargador', $wpfpf_context) . ' : <span>' . $wpfpf_loadercolor . '</span></li>
							  <li>' . __('Color del panel', $wpfpf_context) . ' : <span>' .$wpfpf_panelcolor . '</span></li>
							  <li>' . __('Color de Botones', $wpfpf_context) . ' : <span>' . $wpfpf_buttoncolor. '</span></li>
							  <li>' . __('Color del Texto', $wpfpf_context) . ' : <span>' .$wpfpf_textcolor . '</span></li>
							  <li>' . __('Nombre de la carpeta', $wpfpf_context) . ' : <span>' .$wpfpf_folder_name . '</span></li>
					   		</ul>
						</td>
					</tr>
				</tbody>
			</table>
</div>';
}
// wpfpf_sublevel_page() displays the page content for the first submenu
// of the custom Test Toplevel menu
function wpfpf_sublevel_page() {
Global $wpfpf_context, $wpfpf_nombrecorto, $wpfpf_width, $wpfpf_height,$wpfpf_thumb_width, $wpfpf_thumb_height, $wpfpf_bgcolor, $wpfpf_loadercolor, $wpfpf_panelcolor, $wpfpf_buttoncolor, $wpfpf_textcolor, $wpfpf_folder_name;
$wpfpf_pages_obj = get_pages('sort_column=post_parent,menu_order');
    echo '<div class="wrap">';
    if($_POST['oscimp_hidden'] == 'Y') {
		//Form data sent
		$paginaprincipal = $_POST[$wpfpf_nombrecorto.'paginaprincipal'];
  			if (strlen(get_option($wpfpf_nombrecorto.'paginaprincipal'))<2) {
    			update_option($paginaprincipal, $newvalue);
  			} else {
    			$deprecated=' ';
    			$autoload='no';
    			add_option($paginaprincipal, $newvalue, $deprecated, $autoload);
  			}
		update_option($wpfpf_nombrecorto.'paginaprincipal', $paginaprincipal);
		$paginaprincipal = get_option($wpfpf_nombrecorto."paginaprincipal");
		?>
		<div class="updated"><p><strong><?php _e('Options saved.',$wpfpf_context ); ?></strong></p></div>
		<?php
	} else {
		//Normal page display
		$paginaprincipal = get_option($wpfpf_nombrecorto."paginaprincipal");
	}
   echo "<h2>" . __( 'Configuracion de Wordpress Page Flip Book', $wpfpf_context ) . "</h2>"; ?>
<form name="oscimp_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="oscimp_hidden" value="Y">
	<?php    echo "<h4>" . __( 'Configuracion de la pagina principal', $wpfpf_context ) . "</h4>"; ?>
	<p><?php _e("Debe indicar bajo que pagina ser&aacute;n creados los flipbooks",$wpfpf_context ); ?></p>
	<p><?php _e("Seleccione la pagina padre: ",$wpfpf_context ); ?>
	<select name="<?php echo $wpfpf_nombrecorto.'paginaprincipal';?>">
	<?php
foreach ($wpfpf_pages_obj as $wpfpf_page) {
	$wpfpf_pages[$wpfpf_page->ID] = $wpfpf_page->post_name;
	if($paginaprincipal==$wpfpf_page->ID){
	$selecciona=" selected ";
	}else{
	$selecciona="";
	}
	echo "<option value='".$wpfpf_page->ID."' ".$selecciona.">".$wpfpf_page->post_title."</option>";
}
	?>
	</select>
	<hr />
	<p class="submit">
	<input type="submit" name="Submit" value="<?php _e('Update Options', $wpfpf_context ) ?>" />
	</p>
</form>
</div>
<?php 
}

// wpfpf_sublevel_page2() displays the page content for the second submenu
// of the custom Test Toplevel menu
function wpfpf_acercade() {
Global $wpfpf_context;
    echo "<h2>" . __( 'Acerca de', $wpfpf_context ) . "</h2>";
    echo "<p>".__( 'Copyright 2010 - 2011  Andres Ramiro Molina Romero  (email : amolina@andresmolina.org)', $wpfpf_context )."<br><br>";
    echo  __( 'Plugin Name: Wordpress Flash Page Flip<br>
Plugin URI: http://andresmolina.org/proyectos/wordpress-flash-page-flip-crea-tu-papel-digital-en-pocos-minutos/<br>
Description: Crea un flip book.<br>
Version:1.0.8<br>
Author: Andrés Molina<br>
Author URI: http://andresmolina.org<br>
Twitter: @amolinachile
Donate URI: http://andresmolina.org/proyectos/wordpress-flash-page-flip-crea-tu-papel-digital-en-pocos-minutos/<br>
Thanks to: ezoryak, he translate The plugin to Turkish Language<br>
Thanks to: Borisa Djuraskovic, he translate The plugin to Serbo-Croatian  visit http://www.webhostinghub.com/ <br>
 
License: GPL2</p>', $wpfpf_context );
}

function wpfpf_archivobase() {
 Global $wpfpf_context;
    if(isset($_POST['acepto'])){
     echo "<h2>" . __( 'El archivo se subi&oacute;, comprobando archivo', $wpfpf_context ) . "</h2>";
 		if ($_FILES['losubo']['error'] === UPLOAD_ERR_OK){
 			if($_FILES["losubo"]["type"]=="application/zip"){
    			$tipoarchivo="application/zip";
  			 	include_once('pclzip.lib.php');
  				$zip = new PclZip($_FILES["losubo"]["tmp_name"]);
  				if (($list = $zip->listContent()) == 0) {
    				die("Error : ".$zip->errorInfo(true));
  				}
  			
  				$hay=0;
  				foreach($zip->listContent() as $archivo){
  					if (in_array("Free Version/", $archivo)) {
    					$hay=1;
					}
  				}
    	
				if($hay==1){
					 
						$ruta_destino = dirname(__FILE__)."/";
						move_uploaded_file($_FILES['losubo']['tmp_name'], $ruta_destino."base.zip");
						if (file_exists($ruta_destino."base.zip")) {
    						echo  __("El archivo se subi&oacute; con el nombre base.zip, dentro de la carpeta de tu plugin", $wpfpf_context );
						} else {
    						echo __("Ocurrio un problema al subir el archivo, intenta subiendolo por FTP.", $wpfpf_context );
						}
					 
				
				}else{
				 echo __("El archivo zip debe contener una carpeta llamada <strong>Free Version</strong>.", $wpfpf_context );
				}
 		}else{
    		 if ($_FILES['losubo']['error']) {
          		switch ($_FILES['losubo']['error']){
                   case 1: // UPLOAD_ERR_INI_SIZE
                   echo __("El archivo sobrepasa el limite autorizado por el servidor(archivo php.ini) !", $wpfpf_context);
                   break;
                   case 2: // UPLOAD_ERR_FORM_SIZE
                   echo __("El archivo sobrepasa el limite autorizado en el formulario HTML !", $wpfpf_context);
                   break;
                   case 3: // UPLOAD_ERR_PARTIAL
                   echo __("El envio del archivo ha sido suspendido durante la transferencia!", $wpfpf_context);
                   break;
                   case 4: // UPLOAD_ERR_NO_FILE
                   echo __("El archivo que ha enviado tiene un tamano nulo !", $wpfpf_context);
                   break;
                   case 6: // UPLOAD_ERR_NO_TMP_DIR
                   echo __("No pudimos encontrar el archivo temporal", $wpfpf_context);
                   break;
                   case 7: // UPLOAD_ERR_CANT_WRITE
                   echo __("Fallo en la escritura del archivo en el disco !", $wpfpf_context);
                   break;
                   case 8: // UPLOAD_ERR_EXTENSION
                   echo __("Una extension de php detuvo la subida del archivo !", $wpfpf_context);
                   break;
          		}
			} 
 		} 
    	}else{
    	 echo "<h2>" . __( 'Intentando obtener el archivo desde la URL, comprobando archivo', $wpfpf_context ) . "</h2>";
    	 	if(substr($_POST["archivourl"],-4)==".zip" && substr($_POST["archivourl"],0,28)=="http://www.flashpageflip.com"){
    	 		$ch = curl_init($_POST["archivourl"]);
				$fp = fopen(dirname(__FILE__)."/base.zip", "w");
				curl_setopt($ch, CURLOPT_FILE, $fp);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_exec($ch);
				curl_close($ch);
				fclose($fp);
    	 		include_once('pclzip.lib.php');
  				$zip = new PclZip(dirname(__FILE__)."/base.zip");
  				if (($list = $zip->listContent()) == 0) {
    				die("Error : ".$zip->errorInfo(true));
  				}
  			
  				$hay=0;
  				foreach($zip->listContent() as $archivo){
  					if (in_array("Free Version/", $archivo)) {
    					$hay=1;
					}
  				}
    	
				if($hay==1){
						 echo __("El archivo subio como base.zip a la carpeta de su plugin", $wpfpf_context );
				}else{
				 		echo __("El archivo zip debe contener una carpeta llamada <strong>Free Version</strong>.", $wpfpf_context );
				 		
						unlink(dirname(__FILE__)."base.zip");
				}
				
    	 		
    	 	}else{
    	 	echo "<h2>" . __( 'La url proporcionada no es valida, debe contener un archivo zip y debe comenzar por <strong>http://www.flashpageflip.com</strong>.', $wpfpf_context ) . "</h2>";
    	 	}
    		
    	}

    }else{
    echo "<h2>" . __( 'Instalar Archivo Base de Flash Page Flip', $wpfpf_context ) . "</h2>";
    echo __("<p>Necesitas subir <strong>Flash Page Flip</strong>, puedes copiarlo <a href='http://www.flashpageflip.com/downloads/FreeVersion/FlashPageFlip_FreeVersion.zip'>directamente desde la web del fabricante</a>  o subirlo desde tu computador.<br><br>Antes de subirlo necesitas leer y aceptar los terminos de uso<br><br>", $wpfpf_context );
    ?>
    <div style="border:solid 1px #000">
    <?php _e('Puedes leer los terminos y condiciones desde <a href="http://www.flashpageflip.com/Terms-of-Use.asp" target="_blank">la pagina del fabricante</a> o desde la copia de abajo:', $wpfpf_context );?>
    <?php 
    _e( "<ul>
    	<li>Do not use FPF in web sites providing any kind of illegal content such as pornography, sexuality, adult content, gambling, betting, alcohol or tobacco use, drug abuse etc...</li>
		<li>You can only edit allowed areas on FPF and you cannot deformate except these areas.</li>
		<li>You can't offer FPF for use of any other individuals. Anywise you can't give FPF somebody else.</li>
		<li> You can't use FPF more than the allowed quota of licence which you bought.</li>
		<li>The prices are valid for received product. We don't guarantee new updates but perhaps we will inform you something new.</li>
		<li> Do not forget that disobedience to any of rules listed above is a crime and puts you under legal resbonsibility.</li>
		<li>You agree all rules when you purchase any version of Flash Page Flip.</li>
	</ul>", $wpfpf_context );
    ?>
	</div>
	<form name="wpflashpf_form" method="post" enctype="multipart/form-data" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="CHECKBOX" name="acepto"><?php  _e( 'Acepto los terminos y condiciones', $wpfpf_context )?><br>
	<input type="text" name="archivourl" size="80" value="<?php  _e( 'http://www.flashpageflip.com/downloads/FreeVersion/FlashPageFlip_FreeVersion.zip', $wpfpf_context )?>"><?php _e( 'Copia la url', $wpfpf_context )?><br><br>
	o<br><br>
	<input type="file" name="losubo"><?php  _e( 'Subir desde el computador', $wpfpf_context )?>
	<br><br>
	<input type="submit">
	</form>
<?php
    }

}
function copy_file($download_file)
{
    //get file
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$download_file);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $file = curl_exec($ch);
    curl_close($ch);
    $fp = fopen('temp_zip_file.zip', 'w');
    fwrite($fp, $file);
    fclose($fp);
   //exit;
}

	
// agregamos acciones
function generaflip($post_ID = '')  {
Global $wpfpf_context, $wpfpf_nombrecorto, $wpfpf_width, $wpfpf_height, $wpfpf_bgcolor, $wpfpf_loadercolor, $wpfpf_panelcolor, $wpfpf_buttoncolor, $wpfpf_textcolor, $wpfpf_folder_name;
	$lapfpagina=get_page($post_ID);
	if($lapfpagina->post_parent==get_option($wpfpf_nombrecorto."paginaprincipal") && strlen(get_option($wpfpf_nombrecorto."paginaprincipal"))>0){
		//update_post_meta($post_ID, 'fflip_book',"estas en un hijo de : post id [".$post_ID."] Post parent [".$lapfpagina->post_parent."] nombrecortopaginaprincipal [".get_option($wpfpf_nombrecorto."paginaprincipal")); 
	
	$attachments = get_children(array('post_parent' => $post_ID,
											  'post_status' => 'inherit',
											  'post_type' => 'attachment',
											  'post_mime_type' => 'image',
											  'order' => 'asc',
											  'orderby' => 'menu_order'));

	wp_mkdir_p( WP_CONTENT_DIR."/".$wpfpf_folder_name );

	wp_mkdir_p( WP_CONTENT_DIR."/".$wpfpf_folder_name."/".$lapfpagina->post_name);
	//Si no existe el archivo base.zip en la carpeta de los pageflip lo copiamos desde la carpeta del plugin
	if(!file_exists(WP_CONTENT_DIR."/".$wpfpf_folder_name."/".$lapfpagina->post_name."/base.zip")){
		if(file_exists(dirname(__FILE__)."/base.zip")){
		copy(dirname(__FILE__)."/base.zip", WP_CONTENT_DIR."/".$wpfpf_folder_name."/".$lapfpagina->post_name."/base.zip");
		//rename(WP_CONTENT_DIR."/".$wpfpf_folder_name."/".$lapfpagina->post_name."/Default.html", WP_CONTENT_DIR."/".$wpfpf_folder_name."/".$lapfpagina->post_name."/index.html");
		}
	}

	/*include_once('pclzip.lib.php');
  
  			$zip = new PclZip($_FILES["losubo"]["tmp_name"]);
		
      $archivo = $zip;
    
       
 
      if ($archivo->extract(PCLZIP_OPT_PATH, dirname(__FILE__)."/basek2wes",
  
      PCLZIP_OPT_REMOVE_PATH, "Free Version") == 0) {
   
              die("Error : ".$archivo->errorInfo(true));
    
      }*/
    
     //Si no existe el index.html en la carpeta del pageflip descomprimimos el archivo .zip
	if (!file_exists(WP_CONTENT_DIR."/".$wpfpf_folder_name."/".$lapfpagina->post_name."/index.html")) {
    	require_once('pclzip.lib.php');
    	
		$archive = new PclZip(WP_CONTENT_DIR."/".$wpfpf_folder_name."/".$lapfpagina->post_name."/base.zip");
		if ( 0 == ($files = $archive->extract(PCLZIP_OPT_PATH, WP_CONTENT_DIR."/".$wpfpf_folder_name."/".$lapfpagina->post_name.'/',PCLZIP_OPT_REMOVE_PATH, "Free Version")) ) {
			die("Error : ".$archive->errorInfo(true));
		}
		unlink(WP_CONTENT_DIR."/".$wpfpf_folder_name."/".$lapfpagina->post_name."/base.zip");
		
    	rename(WP_CONTENT_DIR."/".$wpfpf_folder_name."/".$lapfpagina->post_name."/Default.html", WP_CONTENT_DIR."/".$wpfpf_folder_name."/".$lapfpagina->post_name."/index.html");
    
	} 

	//Si existe el archivo Pages.xml lo eliminamos, y creamos uno desde 0, y creamos el contenido del archivo con las rutas hacia las imagenes del pageflip.
	if (file_exists(WP_CONTENT_DIR."/".$wpfpf_folder_name."/".$lapfpagina->post_name."/xml/Pages.xml")) {
		unlink(WP_CONTENT_DIR."/".$wpfpf_folder_name."/".$lapfpagina->post_name."/xml/Pages.xml");

		$fh = fopen(WP_CONTENT_DIR."/".$wpfpf_folder_name."/".$lapfpagina->post_name."/xml/Pages.xml", 'a');


		$contenidofile='<content width="'.$wpfpf_width.'" height="'.$wpfpf_height.'" bgcolor="'.$wpfpf_bgcolor.'" loadercolor="'.$wpfpf_loadercolor.'" panelcolor="'.$wpfpf_panelcolor.'" buttoncolor="'.$wpfpf_buttoncolor.'" textcolor="'.$wpfpf_textcolor.'">'."\n";

			if ($attachments) {
				foreach ($attachments as $posts) {
				$lafoto=wp_get_attachment_image_src($posts->ID, array($wpfpf_width,$wpfpf_height));	
				$contenidofile.= "<page src=\"".$lafoto[0]."\"/>\n";
				}
			}
			
			$contenidofile.="</content>";
			fwrite($fh, $contenidofile);
			fclose($fh);
	} 
//Si existe el archivo index.html modificamos el titulo
	if (file_exists(WP_CONTENT_DIR."/".$wpfpf_folder_name."/".$lapfpagina->post_name."/index.html")) {
	 	$data = file_get_contents(WP_CONTENT_DIR."/".$wpfpf_folder_name."/".$lapfpagina->post_name."/index.html");
        if(preg_match("#<title>(.+?)</title>#is", $data))
        {
        
            //$eltituloheader=get_post_meta($post_ID, 'wordpresspagefliptitulo', true);
            if(strlen($_POST['myplugin_noncename2'])>0){
            	$eltituloheader= utf8_decode($_POST['myplugin_noncename2']);
            }else{
            	$eltituloheader= get_bloginfo('name')." - ".utf8_decode($lapfpagina->post_title);
            }
            $data = preg_replace("#<title>(.+?)</title>#is", "<title>".$eltituloheader."</title>", $data);
            $fp = fopen(WP_CONTENT_DIR."/".$wpfpf_folder_name."/".$lapfpagina->post_name."/index.html", 'w');
            fwrite($fp, $data);
            fclose($fp);
        }
	}
  return $post_ID;
	}
}

function galeria($content = ''){
GLOBAL $post,$wpfpf_context,$wpfpf_folder_name, $wpfpf_thumb_option, $wpfpf_full_name,$wpfpf_lnk_target,$wpfpf_nombrecorto,$wpfpf_thumb_width,$wpfpf_thumb_height;
	
	//die(print_r(get_option($wpfpf_nombrecorto."paginaprincipal")));
	if(is_page(get_option($wpfpf_nombrecorto."paginaprincipal")) ){
		$paginash = get_pages('sort_column=post_date&sort_order=desc&child_of='.get_option($wpfpf_nombrecorto."paginaprincipal"));
		
		 
		$count = 0;
		foreach($paginash as $page)
		{		$count++;
		
 			$attachments = get_children(array('post_parent' => $page->ID,
											  'post_status' => 'inherit',
											  'post_type' => 'attachment',
											  'post_mime_type' => 'image',
 											  'numberposts'=>'1',
											  'order' => 'asc',
											  'orderby' => 'menu_order'));
 	
 			
 			
 			if ($attachments) {
				foreach ($attachments as $images) {
					//echo $wpfpf_thumb_option;
					$lafoto=wp_get_attachment_image_src($images->ID, array($wpfpf_thumb_width,$wpfpf_thumb_height));	
					//die(print_r($lafoto));
					 
					 
					$anchodiv=$wpfpf_thumb_width+10;	
					
				$contenidofile.='
				<div style="width: '.$anchodiv.'px;" class="wp-caption alignleft" id="attachment_'.$images->ID.'">
					<a href="'.WP_CONTENT_URL.'/'.$wpfpf_folder_name.'/'.$page->post_name.'" target="'.$wpfpf_lnk_target.'">
						<img width="'.$wpfpf_thumb_width.'" height="'.$wpfpf_thumb_height.'" alt="'.$images->post_title.'" src="'.$lafoto[0].'" title="'.$images->post_title.'" class="size-medium wp-image-'.$images->ID.'">
						 
						
					</a>
					<p class="wp-caption-text">'.$images->post_title.'</p>
				</div>';

				}
			}
		}	
	
		return $contenidofile;
	}else
		//print_r($post);
	if ( $post->post_parent==get_option($wpfpf_nombrecorto."paginaprincipal")){
	
		 //die(print_r("[]".$content."[]"));
		 $attachments = end(get_children(array('post_parent' => $post->ID,
											  'post_status' => 'inherit',
											  'post_type' => 'attachment',
											  'post_mime_type' => 'image',
 											  'numberposts'=>'1',
											  'order' => 'asc',
											  'orderby' => 'menu_order')));
											  
		$lafoto=wp_get_attachment_image_src($attachments->ID, "large");	
					//die(print_r($lafoto));
					 
					 
					$anchodiv=$lafoto[1]+10;	
					
				$contenidofile.='
				<div style="width: '.$anchodiv.'px;" class="wp-caption alignleft" id="attachment_'.$attachments->ID.'">
					<a href="'.WP_CONTENT_URL.'/'.$wpfpf_folder_name.'/'.$post->post_name.'" target="'.$wpfpf_lnk_target.'">
						<img width="'.$lafoto[1].'" height="'.$lafoto[2].'" alt="'.$attachments->post_title.'" src="'.$lafoto[0].'" title="'.$attachments->post_title.'" class="size-medium wp-image-'.$attachments->ID.'">
						 
						
					</a>
					<p class="wp-caption-text">'.$attachments->post_title.'</p>
				</div>';
		
		
		
		 return $content."<br>".$contenidofile;
			
	}else{
		
	
	return $content;
	}

}
add_action('admin_menu', 'add_pageflip_box');
	function add_pageflip_box() {
		add_meta_box(
	        'tinymce_signature_overrides',
	        'Titulo de la P&aacute;gina(s&oacute;lo para el Page Flip) : ', 
	         'pageflip_box',
	        'page','normal','high'
	    );
	}
	
	function pageflip_box($post) {	
	  wp_nonce_field( plugin_basename(__FILE__), 'myplugin_noncename' );
	  if(get_post_meta($post->ID, 'wordpresspagefliptitulo', true)){
	  	$valortit=get_post_meta($post->ID, 'wordpresspagefliptitulo',true);
	  	
	  }else{
	  	$valortit="";
	  }
	  
 ?>			
					<input type="text" name="myplugin_noncename2" size="60" value="<?php echo $valortit;?>"/>
<?php 		 
		
	}
	function pageflip_save_postdata($post_ID) {


  
  		// Check permissions
  		if ( 'page' == $_POST['post_type'] ) 
  		{
    		if (current_user_can( 'edit_page', $post_id ) ){
        	$mydata = $_POST['myplugin_noncename2'];
 			update_post_meta($post_ID, 'wordpresspagefliptitulo', $mydata);
    		}
  		} 
  		
  		// OK, we're authenticated: we need to find and save the data

  		
   
}
// A–adimos funcionalidad a publish_post
add_action('save_post', 'generaflip');
// A–adimos accion al activar el plugin
add_filter('the_content', 'galeria');
//Añadimos la función para guardar el metabox con el titulo  . Add the code to save the title of the Page Flip(Metabox Under The Content whe you write or edit a page)
add_action('save_post', 'pageflip_save_postdata');


// ejecutar una funcion una vez que WordPress ha cargado
add_action('init', 'wp_flashpageflip_textdomain');

// funci—n para cargar el idioma i18n
function wp_flashpageflip_textdomain() {
Global $wpfpf_context;
    load_plugin_textdomain( $wpfpf_context, false, dirname( plugin_basename( __FILE__ ) )."/lang" );
}

 
add_image_size( $wpfpf_thumb_option, $wpfpf_thumb_width, $wpfpf_thumb_height,true); //(cropped)
add_image_size( $wpfpf_full_name, $wpfpf_width, $wpfpf_height,false); 

?>