<!--
/**
 * COmanage Registry CO Localizations Index View
 *
 * Copyright (C) 2013 University Corporation for Advanced Internet Development, Inc.
 * 
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except in compliance with
 * the License. You may obtain a copy of the License at
 * 
 * http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software distributed under
 * the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 *
 * @copyright     Copyright (C) 2013 University Corporation for Advanced Internet Development, Inc.
 * @link          http://www.internet2.edu/comanage COmanage Project
 * @package       registry
 * @since         COmanage Registry v0.8.3
 * @license       Apache License, Version 2.0 (http://www.apache.org/licenses/LICENSE-2.0)
 * @version       $Id$
 */-->
<?php
  $params = array('title' => $title_for_layout);
  print $this->element("pageTitle", $params);

  // Add buttons to sidebar
  $sidebarButtons = $this->get('sidebarButtons');

  if($permissions['add']) {
    $sidebarButtons[] = array(
      'icon'    => 'circle-plus',
      'title'   => _txt('op.add') . ' ' . _txt('ct.co_localizations.1'),
      'url'     => array(
        'controller' => 'co_localizations', 
        'action' => 'add', 
        'co' => $cur_co['Co']['id']
      )
    );
  }
  
  $this->set('sidebarButtons', $sidebarButtons);
?>

<table id="co_localizations" class="ui-widget">
  <thead>
    <tr class="ui-widget-header">
      <th><?php print $this->Paginator->sort('lkey', _txt('fd.key')); ?></th>
      <th><?php print $this->Paginator->sort('language', _txt('fd.language')); ?></th>
      <th><?php print $this->Paginator->sort('text', _txt('fd.text')); ?></th>
      <th><?php print _txt('fd.actions'); ?></th>
    </tr>
  </thead>
  
  <tbody>
    <?php $i = 0; ?>
    <?php foreach ($co_localizations as $c): ?>
    <tr class="line<?php print ($i % 2)+1; ?>">
      <td>
        <?php
          print $this->Html->link($c['CoLocalization']['lkey'],
                                  array('controller' => 'co_localizations',
                                        'action' => ($permissions['edit'] ? 'edit' : ($permissions['view'] ? 'view' : '')),
                                        $c['CoLocalization']['id'],
                                        'co' => $cur_co['Co']['id']));
        ?>
      </td>
      <td><?php print $c['CoLocalization']['language']; ?></td>
      <td><?php print $c['CoLocalization']['text']; ?></td>
      <td>
        <?php
          if($permissions['edit'])
            print $this->Html->link(_txt('op.edit'),
                                    array('controller' => 'co_localizations',
                                          'action' => 'edit',
                                          $c['CoLocalization']['id'],
                                          'co' => $cur_co['Co']['id']),
                                    array('class' => 'editbutton')) . "\n";
            
          if($permissions['delete'])
            print '<button class="deletebutton" title="' . _txt('op.delete') . '" onclick="javascript:js_confirm_delete(\'' . _jtxt(Sanitize::html($c['CoLocalization']['lkey'])) . '\', \'' . $this->Html->url(array('controller' => 'co_localizations', 'action' => 'delete', $c['CoLocalization']['id'], 'co' => $cur_co['Co']['id'])) . '\')";>' . _txt('op.delete') . '</button>';
        ?>
        <?php ; ?>
      </td>
    </tr>
    <?php $i++; ?>
    <?php endforeach; ?>
  </tbody>
  
  <tfoot>
    <tr class="ui-widget-header">
      <th colspan="4">
        <?php print $this->Paginator->numbers(); ?>
      </th>
    </tr>
  </tfoot>
</table>