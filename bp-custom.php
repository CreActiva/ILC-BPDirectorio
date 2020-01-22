<?php
/*Agregar Bio En Directorio*/
function verificarRol($rol){
   if($rol == 'clc'){
     $respuesta = '<div class="img-tamaño"><div class="col-sm-6 bio clc"></div></div>';
   } elseif($rol == 'cit'){
     $respuesta = '<div class="img-tamaño"><div class="col-sm-6 bio cit"></div></div>';
   } elseif($rol == 'ecoach'){
     $respuesta = '<div class="img-tamaño"><div class="col-sm-6 bio ecoach"></div></div>';
   } else{
     $respuesta = '';
   }
   return $respuesta;
}
function agregar_descripcion(){
   $style = 'padding:0 !important;';
   $miembro = bp_get_member_type(bp_get_member_user_id());settype($miembro,'string');
   $imagen = verificarRol($miembro);
   $bio = bp_get_profile_field_data( 'field=Biografia&user_id=' . bp_get_member_user_id() );
   $link = bp_core_get_user_domain( bp_get_member_user_id() );
   echo '<div class="col-sm-10 bio" style="'.$style.'">'
   .mb_strimwidth($bio, 0, 180, ' ... <a href="'.$link.'">Conocer al coach.</a>').'</div>'.$imagen;
}
add_action( 'bp_directory_members_actions', 'agregar_descripcion', 10, 0 );
function buddydev_exclude_users_by_role( $args ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
        return $args;
    }
    $excluded = isset( $args['exclude'] ) ? $args['exclude'] : array();
    if ( ! is_array( $excluded ) ) {
        $excluded = explode( ',', $excluded );
    }
    $user_ids = get_users( array( 'role__in' => ['translator', 'parcipant', 'moderator', 'blocked', 'spectator','keymaster', 'shop manager', 'customer', 'instructor', 'student', 'suscriptor', 'colaborador', 'autor', 'editor', 'administrator','subscriber'], 'fields' => 'ID' ) );
   for( $i=0; $i < count($user_ids) ; $i++ ){/*Exceptuar usuario 6 (Fer)*/
      if($user_ids[$i] == 6) {
         unset($user_ids[$i]);
         $user_ids = array_values($user_ids);
      }
   }
    $excluded = array_merge( $excluded, $user_ids );
 
    $args['exclude'] = $excluded;
 
    return $args;
}
add_filter( 'bp_after_has_members_parse_args', 'buddydev_exclude_users_by_role' );