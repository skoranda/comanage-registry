<?php
/**
 * COmanage Registry KDC Server Model
 *
 * Portions licensed to the University Corporation for Advanced Internet
 * Development, Inc. ("UCAID") under one or more contributor license agreements.
 * See the NOTICE file distributed with this work for additional information
 * regarding copyright ownership.
 *
 * UCAID licenses this file to you under the Apache License, Version 2.0
 * (the "License"); you may not use this file except in compliance with the
 * License. You may obtain a copy of the License at:
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @link          http://www.internet2.edu/comanage COmanage Project
 * @package       registry
 * @since         COmanage Registry v4.2.0
 * @license       Apache License, Version 2.0 (http://www.apache.org/licenses/LICENSE-2.0)
 */

class KdcServer extends AppModel {
  // Define class name for cake
  public $name = "KdcServer";
  
  // Current schema version for API
  public $version = "1.0";
  
  // Association rules from this model to other models
  public $belongsTo = array("Server");
  
  // Default display field for cake generated views
  public $displayField = "hostname";
  
  public $actsAs = array('Containable');
  
  // Validation rules for table elements
  public $validate = array(
    'server_id' => array(
      'rule' => 'numeric'
    ),
    'hostname' => array(
      'rule' => 'notBlank',
      'required' => true,
      'allowEmpty' => false
    ),
    'admin_hostname' => array(
      'rule' => 'notBlank',
      'required' => false,
      'allowEmpty' => true
    ),
    'principal' => array(
      'rule' => 'notBlank',
      'required' => true,
      'allowEmpty' => false
    ),
    'keytab' => array(
      'rule' => 'notBlank',
      'required' => true,
      'allowEmpty' => false
    )
  );
  
  /**
   * Establish a connection to the specified KDC server.
   *
   * @since  COmanage Registry v4.2.0
   * @param  Integer $serverId Server ID
   * @return KADM5 instance of KADM5
   * @throws Exception
   */
  
  public function connect($serverId) {
    $args = array();
    $args['conditions']['Server.id'] = $serverId;
    $args['contain'] = array('KdcServer');
    
    $srvr = $this->Server->find('first', $args);
    
    if(!$srvr) {
      throw new InvalidArgumentException(_txt('er.notfound', array(_txt('ct.servers.1', $serverId))));
    }

    $principal = $srvr['KdcServer']['principal'];
    $keytab = $srvr['KdcServer']['keytab'];
    $useKeytab = true;

    $conn = new KADM5($principal, $keytab, $useKeytab);
    
    return $conn;
  }
}
