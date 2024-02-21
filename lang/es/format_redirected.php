<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Strings for component 'format_redirected'
 *
 * @package    format_redirected
 * @copyright  2021 Juan Pablo de Castro
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
$string['redirectedcourse'] = 'Este curso está configurado como "Redirigido".';
$string['redirectedhelp'] = 'Este formato de curso redirige a los estudiantes a uno o más cursos. Si sólo hay un curso de destino, la redirección se realiza de forma silenciosa. Si no, se muestra una lista de enlaces a los cursos de destino.';
$string['metalinked'] = 'Este curso está vinculado a los siguientes cursos:';
$string['metalinktext'] = '<div>Fusionado el {$a->creationtime}</div>';
$string['course_redirected_from'] = 'Esta asignatura se ha redireccionado desde: {$a}';
$string['format_redirected_noticeforteachers'] = 'Mensaje para los docentes';
$string['format_redirected_noticeforteachers_desc'] = 'Texto que se mostrará a los profesores en la página de redirección';
$string['format_redirected_defaultnoticeforteachers'] = 'Si cambia el formato del curso sus alumnos podrán entrar en este curso y también en su curso fusionado. Ambos espacios son diferentes y separados. Puede causar confusión.';
$string['format_redirected_defaultnoticeforstudents'] = 'El profesor ha fusionado varios cursos Moodle en otros cursos compartidos. A continuación se muestran los cursos donde realmente se desarrolla la docencia.';
$string['format_redirected_noticeforstudents'] = 'Mensaje para el público en general';
$string['format_redirected_noticeforstudents_desc'] = 'Texto que se mostrará a todos los usuarios en la página de redirección. Está diseñado para indicar el motivo de la redirección';
$string['notredirected_error'] = 'Este curso está configurado como "Redirigido" pero no es posible la redirección. Necesita la intervención del profesor o del administrador.';
$string['pluginname'] = 'Formato curso redirigido';
$string['privacy:metadata'] = 'El plugin de formato Curso Redirigido no almacena ningún dato personal.';
$string['sectionname'] = '';
$string['excludepattern'] = 'Patrón de exclusión de idnumber';
$string['excludepattern_desc'] = 'Patrón de expresión regular para excluir cursos de la lista de cursos a los que se puede redirigir. Se aplica al campo idnumber.';
