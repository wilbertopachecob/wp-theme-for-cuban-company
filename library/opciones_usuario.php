<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 15/12/15
 * Time: 14:18
 */

function user_perfil_scripts()
{
    wp_enqueue_script('media-upload');
    wp_register_script('my-upload', get_bloginfo('stylesheet_directory') . '/library/my-script.js', array('jquery', 'media-upload', 'thickbox'));
    wp_enqueue_script('my-upload');
    wp_enqueue_script('thickbox');
    wp_register_script('user_script', get_bloginfo('stylesheet_directory') . '/library/user_script.js', array('jquery', 'media-upload', 'thickbox'));
    wp_enqueue_script('user_script');
    wp_register_script('bootstrap.min', get_bloginfo('stylesheet_directory') . '/js/bootstrap.min.js', array('jquery'));
    wp_enqueue_script('bootstrap.min');


}

function user_perfil_styles()
{
    wp_enqueue_style('thickbox');
    wp_register_style('icimaf_user', get_bloginfo('stylesheet_directory') . '/library/icimaf_user.css', '', '', 'all');
    wp_enqueue_style('icimaf_user');
    wp_register_style('user_bootstrap.min', get_bloginfo('stylesheet_directory') . '/library/user_bootstrap.min.css', '', '', 'all');
    wp_enqueue_style('user_bootstrap.min');
    /* wp_register_style('icimaf-user-boot', get_bloginfo( 'stylesheet_directory' ) . '/vendors/bootstrap.min.css', '', '', 'all');
     wp_enqueue_style('icimaf-user-boot');*/

}

add_action('admin_print_scripts', 'user_perfil_scripts');
add_action('admin_print_styles', 'user_perfil_styles');


add_action('show_user_profile', 'my_extra_user_fields');
add_action('edit_user_profile', 'my_extra_user_fields');
function my_extra_user_fields($user)
{
    ?>
    <div id="aqui_ajax"></div>
    <h1 class="cabecera"><span style="margin-left: 5px;">ICIMAF</span></h1>
    <table class="form-table">
        <?php if (is_super_admin()): ?>
            <tr>
                <th><label for="user_cargo">Cargo que ocupa</label></th>
                <td>
                    <select id="user_cargo" name="user_cargo">
                        <option value="0"></option>
                        <?php
                        $user_cargo = get_the_author_meta('user_cargo', $user->ID);
                        if ($user_cargo == 1) {
                            echo '
                        <option value="1" selected="selected">Director</option>
                        <option value="2">Subdirector de investigaciones</option>';
                        } else if ($user_cargo == 2) {
                            echo '
                        <option value="1">Director</option>
                        <option value="2" selected="selected">Subdirector de investigaciones</option>';
                        } else {
                            echo '
                        <option value="1">Director</option>
                        <option value="2">Subdirector de investigaciones</option>';
                        }
                        ?>
                    </select>
                </td>
            </tr>
        <?php endif; ?>
        <tr>
            <th><label for="user_consejo_dir">¿Es miembro del Consejo de Cient&iacute;fico?</label></th>
            <td>
                <?php
                $user_consejo_dir = get_the_author_meta('user_consejo_dir', $user->ID);
                echo '<input type="checkbox" id="user_consejo_dir" name="user_consejo_dir" ' . ($user_consejo_dir == 1 ? 'checked' : '') . ' value="1" />';
                ?>

                <span class="description"><?php _e("Marque si lo es."); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="user_departamento">Departamento al que pertenece</label></th>
            <td>
                <select id="user_departamento" name="user_departamento">
                    <?php
                    $user_departamento = get_the_author_meta('user_departamento', $user->ID);
                    $departamentos = array('', 'Control Automático', 'Física Aplicada', 'Física Teórica', 'Matemática', 'Matemática Interdisciplinaria', 'Redes');
                    for ($i = 0; $i < count($departamentos); $i++) {
                        echo '<option value="' . $i . '" ' . ($user_departamento == $i ? 'selected="selected"' : '') . ' >' . $departamentos[$i] . '</option>';
                    }
                    ?>
                </select>

                <span class="description"><?php _e("Escoger un departamento."); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="user_grado_cient">Grado Cient&iacute;fico</label></th>
            <td>
                <select name="user_grado_cient">
                    <?php
                    $user_grado_cient = get_the_author_meta('user_grado_cient', $user->ID);
                    $grados = array('', 'Doctor en Ciencias', 'Doctor', 'Master', 'Ingeniero', 'Licenciado');
                    for ($i = 0; $i < count($grados); $i++) {
                        echo '<option value="' . $i . '" ' . ($user_grado_cient == $i ? 'selected="selected"' : '') . ' >' . $grados[$i] . '</option>';
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="user_curriculo">Curr&iacute;culo</label></th>
            <td>
                <textarea id="user_curriculo" name="user_curriculo" cols="30"
                          rows="10"><?php $user_curriculo = get_the_author_meta('user_curriculo', $user->ID);
                    echo $user_curriculo ? $user_curriculo : ''; ?></textarea>
                <span class="description"><?php _e("Entrar curriculo."); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="user_colaboraciones">Colaboraciones</label></th>
            <td>
                <?php
                $user_colaboraciones = get_the_author_meta('user_colaboraciones', $user->ID);
                $arr_col = explode(';', $user_colaboraciones);
                for ($i = 0; $i < count($arr_col); $i++) {
                    ?>
                    <input name="user_colaboraciones[]" type="text" value="<?php echo $arr_col[$i]; ?>"/>
                    <?php if ($i == 0): ?>
                        <input type="button" name="clonar" class="btn clonar" value="+">
                    <?php endif; ?>
                    <br/>
                <?php } ?>

                <!--<span class="description"><?php _e("Entrar Institutos, Empresas, Entidades, etc. con las que ha colaborado."); ?></span>-->
            </td>
        </tr>
        <!-- <tr>
            <th><label for="user_correos">Otros emails:</label></th>
            <td>
                <?php
                $user_correos = get_the_author_meta('user_correos', $user->ID);

                for ($i = 0; $i < count($user_correos); $i++) {
                    ?>
                    <input name="user_correos[]" type="text" value="<?php echo $user_correos[$i]; ?>"/>
                    <?php if ($i == 0): ?>
                        <input type="button" name="clonar" class="btn clonar" value="+">
                    <?php endif; ?>
                    <br/>
                <?php } ?>
            </td>
        </tr> -->

    </table>

    <h3>Redes Sociales</h3>
    <table class="form-table">
        <tr>
            <th><label for="user_fc">Facebook</label></th>
            <td>
                <input id="user_fc" name="user_fc" type="text"
                       value="<?php $user_fc = get_the_author_meta('user_fc', $user->ID);
                       echo $user_fc ? $user_fc : ''; ?>"/>
                <span class="description"><?php _e("Entrar URL de perfil de Facebook."); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="user_fc">Twitter</label></th>
            <td>
                <input id="user_tw" name="user_tw" type="text"
                       value="<?php $user_tw = get_the_author_meta('user_tw', $user->ID);
                       echo $user_tw ? $user_tw : ''; ?>"/>
                <span class="description"><?php _e("Entrar URL de perfil de Twitter."); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="user_g">Google+</label></th>
            <td>
                <input id="user_g" name="user_g" type="text"
                       value="<?php $user_g = get_the_author_meta('user_g', $user->ID);
                       echo $user_g ? $user_g : ''; ?>"/>
                <span class="description"><?php _e("Entrar URL de perfil de Google+."); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="user_link">LinkedIn</label></th>
            <td>
                <input id="user_link" name="user_link" type="text"
                       value="<?php $user_link = get_the_author_meta('user_link', $user->ID);
                       echo $user_link ? $user_link : ''; ?>"/>
                <span class="description"><?php _e("Entrar URL de perfil de LinkedIn."); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="user_re">Research Gate</label></th>
            <td>
                <input id="user_re" name="user_re" type="text"
                       value="<?php $user_re = get_the_author_meta('user_re', $user->ID);
                       echo $user_re ? $user_re : ''; ?>"/>
                <span class="description"><?php _e("Entrar URL de perfil de Research Gate."); ?></span>
            </td>
        </tr>
        <?php
        //coneccion_externa();
        /*global $wpdb;
        echo "<tr><td>".var_dump($wpdb)."</td></tr>";
        */
        /*$path = $_SERVER['DOCUMENT_ROOT'];
        include_once $path . '/wp-load.php';
        $mydb = new wpdb('root','root','intranet','localhost');
        $rows = $mydb->get_results("SELECT email FROM worker");
        echo "<tr><td><ul>";
        foreach ($rows as $obj) :
           echo "<li>".$obj->email."</li>";
        endforeach;
        echo "</ul></td></tr>";

        $link =  mysql_connect('intranet.icimaf.cu', 'root', 'Icimaf16@');
        if (!$link) {
            die('No pudo conectarse: ' . mysql_error());
        }
        echo 'Conectado  satisfactoriamente';
        mysql_close($link);
*/
        ?>
    </table>
    <h3>Colaboradores</h3>
    <?php
    $user_c_n = get_the_author_meta('nombre_c', $user->ID);
    $user_c_e = get_the_author_meta('email_c', $user->ID);
    $user_c_u = get_the_author_meta('url_c', $user->ID);
    $user_c_d = get_the_author_meta('des_c', $user->ID);
    $user_c_f = get_the_author_meta('foto_c', $user->ID);
    $user_c_a = get_the_author_meta('afiliacion_c', $user->ID);
    if($user_c_n[0] == ''):
     ?>
        <table class="form-table">
            <tr>
                <th><label for="nombre_c">Nombre y Apellidos <span style="color: red;">*</span></label></th>
                <td>
                    <input name="nombre_c[]" type="text"/>
                    <span class="description"><?php _e("Entrar nombre y apellidos del colaborador."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="email_c">Email <span style="color: red;">*</span></label></th>
                <td>
                    <input name="email_c[]" type="email"/>
                    <span class="description"><?php _e("Entrar email del colaborador."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="afiliacion_c">Afiliaci&oacute;n <span style="color: red;">*</span></label></th>
                <td>
                    <input name="afiliacion_c[]" type="text" />
                    <span class="description"><?php _e("Entrar afiliación del colaborador."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="url_c">P&aacute;gina personal</label></th>
                <td>
                    <input name="url_c[]" type="url"/>
                    <span class="description"><?php _e("Entrar URL de p&aacute;gina personal del colaborador."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="des_c">Descripci&oacute;n</label></th>
                <td>
                    <textarea name="des_c[]" cols="30" rows="10"/>

                    </textarea>
                    <span class="description"><?php _e("Entrar descripci&oacute;n del colaborador."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="foto_c">Foto de perfil</label></th>
                <td>
                    <div class="col-xs-5" style="margin-left: 0px;padding-left: 0px;">
                        <input name="foto_c[]"
                               type="text"
                               class="form-control"
                               value=""
                           />
                    </div>
                    <div class="col-xs-2">
                        <input class="upload_button btn btn-primary"
                               type="button"
                               value="<?php echo __("Subir Imagen", "mitema"); ?>"
                            />
                    </div>
                </td>
            </tr>
        </table>

        <?php
else:
    for ($i = 0; $i < count($user_c_n); $i++):
        ?>
        <div onclick="$(this).next().toggle('slow');" class="alert alert-success" role="alert" style="cursor: pointer;">
            <span><?php echo $user_c_n[$i] ? $user_c_n[$i] : ''; ?></span>
            <!--<span aria-hidden="true" style="padding: 0px; 10px;" class="pull-right" onclick="del_colaborador(event, this);">&times;</span>-->
                <button type="button" class="close" onclick="del_colaborador(event, this);"><span aria-hidden="true">&times;</span></button>
        </div>
        <table class="form-table" style="display: none;">
            <tr>
                <th><label for="nombre_c">Nombre y Apellidos <span style="color: red;">*</span></label></th>
                <td>
                    <input name="nombre_c[]" type="text" value="<?php echo $user_c_n[$i] ? $user_c_n[$i] : ''; ?>"/>
                    <span class="description"><?php _e("Entrar nombre y apellidos del colaborador."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="email_c">Email <span style="color: red;">*</span></label></th>
                <td>
                    <input name="email_c[]" type="email" value="<?php echo $user_c_e[$i] ? $user_c_e[$i] : ''; ?>"/>
                    <span class="description"><?php _e("Entrar email del colaborador."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="afiliacion_c">Afiliaci&oacute;n <span style="color: red;">*</span></label></th>
                <td>
                    <input name="afiliacion_c[]" type="text" value="<?php echo $user_c_a[$i] ? $user_c_a[$i] : ''; ?>"/>
                    <span class="description"><?php _e("Entrar afiliación del colaborador."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="url_c">P&aacute;gina personal</label></th>
                <td>
                    <input name="url_c[]" type="url" value="<?php echo $user_c_u[$i] ? $user_c_u[$i] : ''; ?>"/>
                    <span
                        class="description"><?php _e("Entrar URL de p&aacute;gina personal del colaborador."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="des_c">Descripci&oacute;n</label></th>
                <td>
                    <textarea name="des_c[]" cols="30" rows="10"/>
                    <?php echo $user_c_d[$i] ? $user_c_d[$i] : ''; ?>
                    </textarea>
                    <span class="description"><?php _e("Entrar descripci&oacute;n del colaborador."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="foto_c">Foto de perfil</label></th>
                <td>
                    <div class="col-xs-5" style="margin-left: 0px;padding-left: 0px;">
                        <input name="foto_c[]"
                               type="text"
                               class="form-control"
                               value="<?php echo $user_c_f[$i] ? $user_c_f[$i] : ''; ?>"/>
                    </div>
                    <div class="col-xs-2">
                        <input class="upload_button btn btn-primary"
                               type="button"
                               value="<?php echo __("Subir Imagen", "mitema"); ?>"
                            />
                    </div>
                    <div class="col-xs-3">
                        <?php
                        if($user_c_f[$i] != ''):
                            echo '<img style="width: 100%;" src="'.$user_c_f[$i].'" class="img-circle" />';
                        endif;
                        ?>

                    </div>

                </td>
            </tr>
        </table>
    <?php
    endfor;
    endif;

    ?>
    <div id="aqui_col">
    <?php for($i =0; $i < 50; $i++): ?>
        <table class="form-table" style="display: none;">
            <tr>
                <td colspan="2" style="padding: 0px;"><div class="alert alert-success">Nuevo Colaborador</div></td>
            </tr>
            <tr>
                <th><label for="nombre_c">Nombre y Apellidos <span style="color: red;">*</span></label></th>
                <td>
                    <input name="nombre_c[]" type="text" value="" />
                    <span class="description"><?php _e("Entrar nombre y apellidos del colaborador."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="email_c">Email <span style="color: red;">*</span></label></th>
                <td>
                    <input name="email_c[]" type="email"/>
                    <span class="description"><?php _e("Entrar email del colaborador."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="afiliacion_c">Afiliaci&oacute;n <span style="color: red;">*</span></label></th>
                <td>
                    <input name="afiliacion_c[]" type="text" />
                    <span class="description"><?php _e("Entrar afiliación del colaborador."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="url_c">P&aacute;gina personal</label></th>
                <td>
                    <input name="url_c[]" type="url"/>
                    <span class="description"><?php _e("Entrar URL de p&aacute;gina personal del colaborador."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="des_c">Descripci&oacute;n</label></th>
                <td>
                    <textarea name="des_c[]" cols="30" rows="10"/>

                    </textarea>
                    <span class="description"><?php _e("Entrar descripci&oacute;n del colaborador."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="foto_c">Foto de perfil</label></th>
                <td>
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5" style="margin-left: 0px;padding-left: 0px;">
                        <input name="foto_c[]"
                               type="text"
                               class="form-control"
                            />
                    </div>
                    <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2">
                        <input id="upload_image_button"
                               class="upload_button btn btn-primary"
                               type="button"
                               value="<?php echo __("Subir Imagen", "mitema"); ?>"
                            />
                    </div>

                </td>
            </tr>
        </table>
    <?php endfor; ?>
    </div>
    <input id="add_c"
           class="btn btn-primary"
           type="button"
           value="Añadir colaborador"
           onclick="new_colaborador();"
        />

    <h3>Estudiantes</h3>
    <?php
    $user_e_n = get_the_author_meta('nombre_e', $user->ID);
    $user_e_e = get_the_author_meta('email_e', $user->ID);
    $user_e_u = get_the_author_meta('url_e', $user->ID);
    $user_e_d = get_the_author_meta('des_e', $user->ID);
    $user_e_f = get_the_author_meta('foto_e', $user->ID);
    $user_e_a = get_the_author_meta('afiliacion_e', $user->ID);
    if($user_e_n[0] == ''):
     ?>
        <table class="form-table">
            <tr>
                <th><label for="nombre_e">Nombre y Apellidos <span style="color: red;">*</span></label></th>
                <td>
                    <input name="nombre_e[]" type="text"/>
                    <span class="description"><?php _e("Entrar nombre y apellidos del estudiante."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="email_e">Email <span style="color: red;">*</span></label></th>
                <td>
                    <input name="email_e[]" type="email"/>
                    <span class="description"><?php _e("Entrar email del estudiante."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="afiliacion_e">Afiliaci&oacute;n <span style="color: red;">*</span></label></th>
                <td>
                    <input name="afiliacion_e[]" type="text" />
                    <span class="description"><?php _e("Entrar afiliación del estudiante."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="url_e">P&aacute;gina personal</label></th>
                <td>
                    <input name="url_e[]" type="url"/>
                    <span class="description"><?php _e("Entrar URL de p&aacute;gina personal del estudiante."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="des_e">Descripci&oacute;n</label></th>
                <td>
                    <textarea name="des_e[]" cols="30" rows="10"/>

                    </textarea>
                    <span class="description"><?php _e("Entrar descripci&oacute;n del estudiante."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="foto_e">Foto de perfil</label></th>
                <td>
                    <div class="col-xs-5" style="margin-left: 0px;padding-left: 0px;">
                        <input name="foto_e[]"
                               type="text"
                               class="form-control"
                               value=""
                           />
                    </div>
                    <div class="col-xs-2">
                        <input class="upload_button btn btn-primary"
                               type="button"
                               value="<?php echo __("Subir Imagen", "mitema"); ?>"
                            />
                    </div>
                </td>
            </tr>
        </table>

        <?php
else:
    for ($i = 0; $i < count($user_e_n); $i++):
        ?>
        <div onclick="$(this).next().toggle('slow');" class="alert alert-success" role="alert" style="cursor: pointer;">
            <span><?php echo $user_e_n[$i] ? $user_e_n[$i] : ''; ?></span>
            <!--<span aria-hidden="true" style="padding: 0px; 10px;" class="pull-right" onclick="del_colaborador(event, this);">&times;</span>-->
                <button type="button" class="close" onclick="del_colaborador(event, this);"><span aria-hidden="true">&times;</span></button>
        </div>
        <table class="form-table" style="display: none;">
            <tr>
                <th><label for="nombre_e">Nombre y Apellidos <span style="color: red;">*</span></label></th>
                <td>
                    <input name="nombre_e[]" type="text" value="<?php echo $user_e_n[$i] ? $user_e_n[$i] : ''; ?>"/>
                    <span class="description"><?php _e("Entrar nombre y apellidos del estudiante."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="email_e">Email <span style="color: red;">*</span></label></th>
                <td>
                    <input name="email_e[]" type="email" value="<?php echo $user_e_e[$i] ? $user_e_e[$i] : ''; ?>"/>
                    <span class="description"><?php _e("Entrar email del estudiante."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="afiliacion_e">Afiliaci&oacute;n <span style="color: red;">*</span></label></th>
                <td>
                    <input name="afiliacion_e[]" type="text" value="<?php echo $user_e_a[$i] ? $user_e_a[$i] : ''; ?>"/>
                    <span class="description"><?php _e("Entrar afiliación del estudiante."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="url_e">P&aacute;gina personal</label></th>
                <td>
                    <input name="url_e[]" type="url" value="<?php echo $user_e_u[$i] ? $user_e_u[$i] : ''; ?>"/>
                    <span
                        class="description"><?php _e("Entrar URL de p&aacute;gina personal del estudiante."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="des_e">Descripci&oacute;n</label></th>
                <td>
                    <textarea name="des_e[]" cols="30" rows="10"/>
                    <?php echo $user_e_d[$i] ? $user_e_d[$i] : ''; ?>
                    </textarea>
                    <span class="description"><?php _e("Entrar descripci&oacute;n del estudiante."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="foto_e">Foto de perfil</label></th>
                <td>
                    <div class="col-xs-5" style="margin-left: 0px;padding-left: 0px;">
                        <input name="foto_e[]"
                               type="text"
                               class="form-control"
                               value="<?php echo $user_e_f[$i] ? $user_e_f[$i] : ''; ?>"/>
                    </div>
                    <div class="col-xs-2">
                        <input class="upload_button btn btn-primary"
                               type="button"
                               value="<?php echo __("Subir Imagen", "mitema"); ?>"
                            />
                    </div>
                    <div class="col-xs-3">
                        <?php
                        if($user_e_f[$i] != ''):
                            echo '<img style="width: 100%;" src="'.$user_e_f[$i].'" class="img-circle" />';
                        endif;
                        ?>

                    </div>

                </td>
            </tr>
        </table>
    <?php
    endfor;
    endif;

    ?>
    <div id="aqui_est">
    <?php for($i =0; $i < 50; $i++): ?>
        <table class="form-table" style="display: none;">
            <tr>
                <td colspan="2" style="padding: 0px;"><div class="alert alert-success">Nuevo Estudiante</div></td>
            </tr>
            <tr>
                <th><label for="nombre_e">Nombre y Apellidos <span style="color: red;">*</span></label></th>
                <td>
                    <input name="nombre_e[]" type="text" value="" />
                    <span class="description"><?php _e("Entrar nombre y apellidos del estudiante."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="email_e">Email <span style="color: red;">*</span></label></th>
                <td>
                    <input name="email_e[]" type="email"/>
                    <span class="description"><?php _e("Entrar email del estudiante."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="afiliacion_e">Afiliaci&oacute;n <span style="color: red;">*</span></label></th>
                <td>
                    <input name="afiliacion_e[]" type="text" />
                    <span class="description"><?php _e("Entrar afiliación del estudiante."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="url_e">P&aacute;gina personal</label></th>
                <td>
                    <input name="url_e[]" type="url"/>
                    <span class="description"><?php _e("Entrar URL de p&aacute;gina personal del estudiante."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="des_e">Descripci&oacute;n</label></th>
                <td>
                    <textarea name="des_e[]" cols="30" rows="10"/>

                    </textarea>
                    <span class="description"><?php _e("Entrar descripci&oacute;n del estudiante."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="foto_e">Foto de perfil</label></th>
                <td>
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5" style="margin-left: 0px;padding-left: 0px;">
                        <input name="foto_e[]"
                               type="text"
                               class="form-control"
                            />
                    </div>
                    <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2">
                        <input id="upload_image_button"
                               class="upload_button btn btn-primary"
                               type="button"
                               value="<?php echo __("Subir Imagen", "mitema"); ?>"
                            />
                    </div>

                </td>
            </tr>
        </table>
    <?php endfor; ?>
    </div>
    <input id="add_c"
           class="btn btn-primary"
           type="button"
           value="Añadir estudiante"
           onclick="new_estudiante();"
        />
<?php
}

add_action('personal_options_update', 'save_my_extra_user_fields');
add_action('edit_user_profile_update', 'save_my_extra_user_fields');

function save_my_extra_user_fields($user_id)
{
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    } else {

        if (isset($_POST['user_cargo']) && $_POST['user_cargo'] != "") {
            update_usermeta($user_id, 'user_cargo', $_POST['user_cargo']);
        }
        if (isset($_POST['user_consejo_dir']) && $_POST['user_consejo_dir'] != "") {
            update_usermeta($user_id, 'user_consejo_dir', $_POST['user_consejo_dir']);
        } else {
            delete_user_meta($user_id, 'user_consejo_dir');
        }
        if (isset($_POST['user_departamento']) && $_POST['user_departamento'] != "") {
            update_usermeta($user_id, 'user_departamento', $_POST['user_departamento']);
        }
        if (isset($_POST['user_grado_cient']) && $_POST['user_grado_cient'] != "") {
            update_usermeta($user_id, 'user_grado_cient', $_POST['user_grado_cient']);
        }
        if (isset($_POST['user_curriculo']) && $_POST['user_curriculo'] != "") {
            update_usermeta($user_id, 'user_curriculo', $_POST['user_curriculo']);
        }
        if (isset($_POST['user_colaboraciones'])) {
            $aux = array();
            for ($i = 0; $i < count($_POST['user_colaboraciones']); $i++) {
                if ($_POST['user_colaboraciones'][$i] != "")
                    $aux[] = $_POST['user_colaboraciones'][$i];
            }
            $cadena_col = implode(';', $aux);
            unset($aux);
            update_usermeta($user_id, 'user_colaboraciones', $cadena_col);
        }
        if (isset($_POST['user_correos'])) {
            for ($i = 0; $i < count($_POST['user_correos']); $i++):
                if ($_POST['user_correos'][$i] != ''):
                    $arr[] = $_POST['user_correos'][$i];
                endif;
            endfor;
            update_usermeta($user_id, 'user_correos', $arr);
        }
        if (isset($_POST['user_fc']) && $_POST['user_fc'] != "") {
            update_usermeta($user_id, 'user_fc', $_POST['user_fc']);
        }
        if (isset($_POST['user_tw']) && $_POST['user_tw'] != "") {
            update_usermeta($user_id, 'user_tw', $_POST['user_tw']);
        }
        if (isset($_POST['user_g']) && $_POST['user_g'] != "") {
            update_usermeta($user_id, 'user_g', $_POST['user_g']);
        }
        if (isset($_POST['user_link']) && $_POST['user_link'] != "") {
            update_usermeta($user_id, 'user_link', $_POST['user_link']);
        }
        if (isset($_POST['user_re']) && $_POST['user_re'] != "") {
            update_usermeta($user_id, 'user_re', $_POST['user_re']);
        }

        //Agregando Colaboradores
        delete_user_meta($user_id, 'nombre_c');
        delete_user_meta($user_id, 'email_c');
        delete_user_meta($user_id, 'url_c');
        delete_user_meta($user_id, 'des_c');
        delete_user_meta($user_id, 'foto_c');
        delete_user_meta($user_id, 'afiliacion_c');
        delete_user_meta($user_id, 'flag_c');
        if (isset($_POST['nombre_c'])) {
            for ($i = 0; $i < count($_POST['nombre_c']); $i++):
                if ($_POST['nombre_c'][$i] != ''):
                    $arr[] = $_POST['nombre_c'][$i];
                endif;
            endfor;
            if(isset($arr) AND count($arr) > 0){
                update_usermeta($user_id, 'flag_c', 1);
                update_usermeta($user_id, 'nombre_c', $arr);
                update_usermeta($user_id, 'email_c', $_POST['email_c']);
                update_usermeta($user_id, 'url_c', $_POST['url_c']);
                update_usermeta($user_id, 'des_c', $_POST['des_c']);
                update_usermeta($user_id, 'foto_c', $_POST['foto_c']);
                update_usermeta($user_id, 'afiliacion_c', $_POST['afiliacion_c']);
            }
        }

        //Agregando Estudiantes
        delete_user_meta($user_id, 'nombre_e');
        delete_user_meta($user_id, 'email_e');
        delete_user_meta($user_id, 'url_e');
        delete_user_meta($user_id, 'des_e');
        delete_user_meta($user_id, 'foto_e');
        delete_user_meta($user_id, 'afiliacion_e');
        delete_user_meta($user_id, 'flag_e');
        if (isset($_POST['nombre_e'])) {
            for ($i = 0; $i < count($_POST['nombre_e']); $i++):
                if ($_POST['nombre_e'][$i] != ''):
                    $arr_e[] = $_POST['nombre_e'][$i];
                endif;
            endfor;
            if(isset($arr_e) AND count($arr_e) > 0){
                update_usermeta($user_id, 'flag_e', 1);
                update_usermeta($user_id, 'nombre_e', $arr_e);
                update_usermeta($user_id, 'email_e', $_POST['email_e']);
                update_usermeta($user_id, 'url_e', $_POST['url_e']);
                update_usermeta($user_id, 'des_e', $_POST['des_e']);
                update_usermeta($user_id, 'foto_e', $_POST['foto_e']);
                update_usermeta($user_id, 'afiliacion_e', $_POST['afiliacion_e']);
            }
        }
    }
}

