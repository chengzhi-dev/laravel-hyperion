<!-- Styles -->
<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/docs.css') }}" rel="stylesheet">

<div class="main_div_container">
    <div class="pull-left">
      <h1>Hyperion API's</h1>
    </div>
    <div class="clearfix"></div>

  <article>
    <div class="pull-left">
      <h1>1. Cicare(Reinsurance) User - Create/Update</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="post" style="">
        <code><span class="pln">CREATE URL - /api/reins/create_user</span></code>
        <code><span class="pln">UPDATE URL - /api/reins/update_user</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>fullname</td>
              <td>String</td>
              <td><p>Users fullname</p></td>
          </tr>
          <tr>
              <td>email</td>
              <td>String</td>
              <td><p>Users email address</p></td>
          </tr>
          <tr>
              <td>password</td>
              <td>String</td>
              <td><p>User password</p></td>
          </tr>
          <tr>
              <td>status</td>
              <td>String</td>
              <td><p>User password</p></td>
          </tr>
          <tr>
              <td>reinsurances_id</td>
              <td>Object Id</td>
              <td><p>Reinsurance company id</p></td>
          </tr>
          <tr>
              <td>users_reinsurances_role_id</td>
              <td>Object Id</td>
              <td><p>Reinsurance user role id</p></td>
          </tr>
          <tr>
              <td>acronym</td>
              <td>string</td>
              <td><p>User acronym</p></td>
          </tr>
          <tr>
              <td>position</td>
              <td>Object Id</td>
              <td><p>User geographique position</p></td>
          </tr>
           <tr>
              <td>gender</td>
              <td>Object Id</td>
              <td><p>User gender</p></td>
          </tr>
          <tr>
           <tr>
              <td>civility</td>
              <td>Object Id</td>
              <td><p>User civility</p></td>
          </tr>
          <tr>
              <td>signature</td>
              <td>File type(image)</td>
              <td><p>Reinsurance user signature in image format</p></td>
          </tr>
          <tr>
              <td>photo</td>
              <td>File type(image)</td>
              <td><p>Reinsurance user picture</p></td>
          </tr>
           <tr>
              <td>stamp</td>
              <td>File type(image)</td>
              <td><p>Reinsurance user stamp</p></td>
          </tr>
          <tr>
              <td>user_id (Only in case of update user)</td>
              <td>Object Id (hidden)</td>
              <td><p>Reinsurance user ID</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "user_id" : "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUz",
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>2. Cicare(Reinsurance) User - Login</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="post" style="">
        <code><span class="pln">/api/reins/login_user</span></code>
    </pre>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 10%">Type</th>
            <th style="width: 60%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>email</td>
              <td>String</td>
              <td><p>Users email address</p></td>
          </tr>
          <tr>
              <td>password</td>
              <td>String</td>
              <td><p>User password</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "token" : "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGmY2MTFmMGM5ZDBj",
                            "userDetail": array having user params
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>3. Cicare(Reinsurance) User - Create/Update profile</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="post" style="">
        <code><span class="pln">CREATE URL - /api/reins/create_profile</span></code>
        <code><span class="pln">UPDATE URL - /api/reins/update_profile</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 10%">Type</th>
            <th style="width: 60%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>name</td>
              <td>String</td>
              <td><p>Profile name</p></td>
          </tr>
          <tr>
              <td>description</td>
              <td>String</td>
              <td><p>Profile description</p></td>
          </tr>
          <tr>
              <td>modules_id</td>
              <td>Object Id</td>
              <td><p>Modules ID (multiple modules can be selected)</p></td>
          </tr>
          <tr>
              <td>user_profile_id (Only in case of update profile)</td>
              <td>Object Id (hidden)</td>
              <td><p>Profiles ID</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "user_profile_id" : "eyJ0eXAiOiJKV1Q",
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>4. Cicare(Reinsurance) Group - Create/Update group for cedants</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="post" style="">
        <code><span class="pln">CREATE URL - /api/reins/create_group</span></code>
        <code><span class="pln">UPDATE URL - /api/reins/update_group</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 10%">Type</th>
            <th style="width: 60%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>name</td>
              <td>String</td>
              <td><p>Name of the group</p></td>
          </tr>
          <tr>
              <td>group_id (Only in case of update group)</td>
              <td>Object Id (hidden)</td>
              <td><p>Group ID</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "group_id" : "eyJ0eXAiOiJKV1Q",
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>5. Cicare(Reinsurance) Cedants - Create/Update insurance company</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="post" style="">
        <code><span class="pln">CREATE URL - /api/reins/create_cedant</span></code>
        <code><span class="pln">UPDATE URL - /api/reins/update_cedant</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>name</td>
              <td>String</td>
              <td><p>Name of the insurance company</p></td>
          </tr>
          <tr>
              <td>email</td>
              <td>String</td>
              <td><p>Email of the insurance company</p></td>
          </tr>
          <tr>
              <td>groups_cedants_id</td>
              <td>Object Id</td>
              <td><p>Group of the insurance company</p></td>
          </tr>
          <tr>
              <td>reinsurances_id</td>
              <td>Object Id</td>
              <td><p>Reinsurance related to the insurance company</p></td>
          </tr>
          <tr>
              <td>contact</td>
              <td>String</td>
              <td><p>Conatct number of the insurance company</p></td>
          </tr>
          <tr>
              <td>logo</td>
              <td>File type(image)</td>
              <td><p>Logo of the insurance company in image format</p></td>
          </tr>
          <tr>
              <td>color1</td>
              <td>String</td>
              <td><p>Primary color of the insurance company</p></td>
          </tr>
          <tr>
              <td>color2</td>
              <td>String</td>
              <td><p>Secondary color of the insurance company</p></td>
          </tr>
          <tr>
              <td>countries_id</td>
              <td>Object Id</td>
              <td><p>Country of the insurance company</p></td>
          </tr>
          <tr>
              <td>region_id</td>
              <td>Object Id</td>
              <td><p>Region of the insurance company</p></td>
          </tr>
          <tr>
              <td>types_cedants_id</td>
              <td>Object Id</td>
              <td><p>Insurance company type - Life/ Not life</p></td>
          </tr>
          <tr>
              <td>currencies_id</td>
              <td>Object Id</td>
              <td><p>Currency</p></td>
          </tr>
          <tr>
              <td>benefit_percentage</td>
              <td>String</td>
              <td><p>Benefit percentage of the insurance company</p></td>
          </tr>
          <tr>
              <td>ins_id (Only in case of update insurance company)</td>
              <td>Object Id (hidden)</td>
              <td><p>Insurance Company ID</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "ins_id" : "eyJ0eXAiOiJKV1Q",
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>6. Cicare(Reinsurance) Cedants - Create/Update insurance user</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="post" style="">
        <code><span class="pln">CREATE URL - /api/reins/create_cedant_user</span></code>
        <code><span class="pln">UPDATE URL - /api/reins/update_cedant_user</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>username</td>
              <td>String</td>
              <td><p>Username of the insurance company user</p></td>
          </tr>
          <tr>
              <td>email</td>
              <td>String</td>
              <td><p>Email of the insurance company user</p></td>
          </tr>
          <tr>
              <td>password</td>
              <td>String</td>
              <td><p>Password of the insurance company user</p></td>
          </tr>
          <tr>
              <td>status</td>
              <td>String</td>
              <td><p>Status of the insurance company user</p></td>
          </tr>
          <tr>
              <td>cedants_id</td>
              <td>Object Id</td>
              <td><p>Id of the related insurance company</p></td>
          </tr>
          <tr>
              <td>users_cedants_role_id</td>
              <td>Object Id</td>
              <td><p>Role of the insurance company user</p></td>
          </tr>
          <tr>
              <td>signature</td>
              <td>File type(image)</td>
              <td><p>Signature uploaded of the insurance company user in image format</p></td>
          </tr>
          <tr>
              <td>ip_address</td>
              <td>String</td>
              <td><p>IP Address of the insurance company user</p></td>
          </tr>
          <tr>
              <td>user_id (Only in case of update insurance user)</td>
              <td>Object Id (hidden)</td>
              <td><p>Cedant User ID</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "user_id" : "eyJ0eXAiOiJKV1Q",
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>7. Cicare(Reinsurance) Cedants - Create/Update insurance type</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="post" style="">
        <code><span class="pln">CREATE URL - /api/reins/create_insurance_type</span></code>
        <code><span class="pln">UPDATE URL - /api/reins/update_insurance_type</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>name</td>
              <td>String</td>
              <td><p>Name of the insurance type</p></td>
          </tr>
          <tr>
              <td>ins_type_id (Only in case of update insurance type)</td>
              <td>Object Id (hidden)</td>
              <td><p>Insurance company type ID</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "ins_type_id" : "eyJ0eXAiOiJKV1Q",
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>7. Cedants(Insurance Company) - Create/Update user</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="post" style="">
        <code><span class="pln">CREATE URL - /api/ins/create_user</span></code>
        <code><span class="pln">UPDATE URL - /api/ins/update_user</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>username</td>
              <td>String</td>
              <td><p>Username of the insurance company user</p></td>
          </tr>
          <tr>
              <td>email</td>
              <td>String</td>
              <td><p>Email of the insurance company user</p></td>
          </tr>
          <tr>
              <td>password</td>
              <td>String</td>
              <td><p>Password of the insurance company user</p></td>
          </tr>
          <tr>
              <td>status</td>
              <td>String</td>
              <td><p>Status of the insurance company user</p></td>
          </tr>
          <tr>
              <td>cedants_id</td>
              <td>Object Id</td>
              <td><p>Id of the related insurance company</p></td>
          </tr>
          <tr>
              <td>users_cedants_role_id</td>
              <td>Object Id</td>
              <td><p>Role of the insurance company user</p></td>
          </tr>
          <tr>
              <td>signature</td>
              <td>File type(image)</td>
              <td><p>Signature uploaded of the insurance company user in image format</p></td>
          </tr>
          <tr>
              <td>ip_address</td>
              <td>String</td>
              <td><p>IP Address of the insurance company user</p></td>
          </tr>
          <tr>
              <td>user_id (Only in case of update user)</td>
              <td>Object Id (hidden)</td>
              <td><p>Cedant user ID</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "user_id" : "eyJ0eXAiOiJKV1Q",
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>8. Cedants(Insurance Company) User - Login</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="post" style="">
        <code><span class="pln">/api/ins/login_user</span></code>
    </pre>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 10%">Type</th>
            <th style="width: 60%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>email</td>
              <td>String</td>
              <td><p>Users email address</p></td>
          </tr>
          <tr>
              <td>password</td>
              <td>String</td>
              <td><p>User password</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "token" : "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGmY2MTFmMGM5ZDBj",
                            "userDetail": array having user params
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>9. Cicare(Reinsurance) Cedants - Check premium slip case wise</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">URL - /api/reins/check_cases_premium_slip/:validation_status/:cases_id}/:cedants_type_id</span></code>
        <code><span class="pln">For ex - /api/reins/check_cases_premium_slip/1/vdf14t5ggfg77rert/uyuyy7585mfmf</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>validation_status</td>
              <td>Boolean(0/1)</td>
              <td><p>Validation Status of the slip where 0 indicates Rejected and 1 indicates Verified</p></td>
          </tr>
          <tr>
              <td>cases_id</td>
              <td>Object id</td>
              <td><p>Case id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "cases_id" : "eyJ0eXAiOiJKV1Q",
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>10. Cicare(Reinsurance) Cedants - List of premium slips</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">URL - /api/reins/list_premium_slips/:reinsurances_id</span></code>
        <code><span class="pln">For ex - /api/reins/list_premium_slips/vdf14t5ggfg77rert</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>reinsurances_id</td>
              <td>Object Id</td>
              <td><p>Reinsurances id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "list_premiums" : premium list array,
                            "premium_cases" : premium_cases array
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>11. Cicare(Reinsurance) Cedants - View detail of premium slip</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">URL - /api/reins/view_premium_slip/:premium_slip_id</span></code>
        <code><span class="pln">For ex - /api/reins/view_premium_slip/vdf14t5ggfg77rert</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>premium_slip_id</td>
              <td>Object Id</td>
              <td><p>Slips premium id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "premium_slip_detail" : premium slip data object,
                            "premium_cases" : premium cases objects,
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>12. Cedants(Insurance company) - Check premium slip</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">URL - /api/ins/check_premium_slip/:approval_status/:premium_slip_id</span></code>
        <code><span class="pln">For ex - /api/ins/check_premium_slip/1/vdf14t5ggfg77rert</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>approval_status</td>
              <td>Boolean(0/1)</td>
              <td><p>Approval Status of the slip where 0 indicates Rejected and 1 indicates Verified</p></td>
          </tr>
          <tr>
              <td>premium_slip_id</td>
              <td>Object id</td>
              <td><p>Slips premium id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "premium_slip_id" : "eyJ0eXAiOiJKV1Q",
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>13. Cedants(Insurance company) - List of premium slips</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">URL - /api/ins/list_premium_slips/:cedants_id</span></code>
        <code><span class="pln">For ex - /api/ins/list_premium_slips/vdf14t5ggfg77rert</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>cedants_id</td>
              <td>Object Id</td>
              <td><p>Cedants id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "list_premiums" : premium list array,
                            "premium_cases" : premium cases array
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>14. Cedants(Insurance company) - View detail of premium slip</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">URL - /api/ins/view_premium_slip/:premium_slip_id</span></code>
        <code><span class="pln">For ex - /api/ins/view_premium_slip/vdf14t5ggfg77rert</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>premium_slip_id</td>
              <td>Object Id</td>
              <td><p>Slips premium id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "premium_slip_detail" : premium slip data object,
                            "premium_cases" : premium cases objects
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>14. Cedants(Insurance company) - Create/Update premium slip</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="post" style="">
        <code><span class="pln">Create URL - /api/ins/create_premium_slip</span></code>
        <code><span class="pln">Update URL - /api/ins/update_premium_slip</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>file</td>
              <td>file(xslx)</td>
              <td><p>Upload a excel file having slips data and case data. Parameters
                      required in the excel are mentioned below:-
                  </p></td>
          </tr>
          <tr>
              <td>reference</td>
              <td>String</td>
              <td><p>Reference</p></td>
          </tr>
          <tr>
              <td>cedants_id</td>
              <td>Object Id</td>
              <td><p>Cedant id</p></td>
          </tr>
          <tr>
              <td>cedants_type_id</td>
              <td>Object Id</td>
              <td><p>Cedant type id</p></td>
          </tr>
          <tr>
              <td>reinsurances_id</td>
              <td>Object Id</td>
              <td><p>Reinsurances id</p></td>
          </tr>
          <tr>
              <td>edited_period</td>
              <td>String</td>
              <td><p>Period</p></td>
          </tr>
          <tr>
              <td>case_id (Only in case of update premium slip)</td>
              <td>Object Id (hidden)</td>
              <td><p>Slip case id</p></td>
          </tr>
          <tr>
              <td>premium_slip_id (Only in case of update premium slip)</td>
              <td>Object Id (hidden)</td>
              <td><p>Slips prime id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "premium_slip_id" : 'ffdf454fsdtt'
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>15. Cedants(Insurance company) - List of users</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">URL - /api/ins/list_users/:cedants_id</span></code>
        <code><span class="pln">For ex - /api/ins/list_users/vdf14t5ggfg77rert</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>cedants_id</td>
              <td>Object Id</td>
              <td><p>Cedants id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "list_users" : users list array,
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>16. Cicare(Reinsurance company) - List of users</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">URL - /api/reins/list_users/:reinsurances_id</span></code>
        <code><span class="pln">For ex - /api/reins/list_users/vdf14t5ggfg77rert</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>reinsurances_id</td>
              <td>Object Id</td>
              <td><p>Reinsurances id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "list_users" : users list array,
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>17. Get authenticated user details</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">URL - /api/reins/getAuthenticatedUser</span></code>
        <code><span class="pln">URL - /api/ins/getAuthenticatedUser</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "user" : users list array,
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>18. Cicare(Reinsurance) Cedants - Check claim slip case wise</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">URL - /api/reins/check_cases_claim_slip/:validation_status/:cases_id}/:cedants_type_id</span></code>
        <code><span class="pln">For ex - /api/reins/check_cases_claim_slip/1/vdf14t5ggfg77rert/uyuyy7585mfmf</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>validation_status</td>
              <td>Boolean(0/1)</td>
              <td><p>Validation Status of the slip where 0 indicates Rejected and 1 indicates Verified</p></td>
          </tr>
          <tr>
              <td>cases_id</td>
              <td>Object id</td>
              <td><p>Case id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "cases_id" : "eyJ0eXAiOiJKV1Q",
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>19. Cicare(Reinsurance) Cedants - List of claim slips</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">URL - /api/reins/list_claim_slips/:reinsurances_id</span></code>
        <code><span class="pln">For ex - /api/reins/list_claim_slips/vdf14t5ggfg77rert</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>reinsurances_id</td>
              <td>Object Id</td>
              <td><p>Reinsurances id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "list_claims" : claim list array,
                            "claim_cases" : claim_cases array
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>20. Cicare(Reinsurance) Cedants - View detail of claim slip</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">URL - /api/reins/view_claim_slip/:claim_slip_id</span></code>
        <code><span class="pln">For ex - /api/reins/view_claim_slip/vdf14t5ggfg77rert</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>claim_slip_id</td>
              <td>Object Id</td>
              <td><p>Slips claim id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "claim_slip_detail" : claim slip data object,
                            "claim_cases" : claim cases objects,
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>21. Cedants(Insurance company) - Check claim slip</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">URL - /api/ins/check_claim_slip/:approval_status/:claim_slip_id</span></code>
        <code><span class="pln">For ex - /api/ins/check_claim_slip/1/vdf14t5ggfg77rert</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>approval_status</td>
              <td>Boolean(0/1)</td>
              <td><p>Approval Status of the slip where 0 indicates Rejected and 1 indicates Verified</p></td>
          </tr>
          <tr>
              <td>claim_slip_id</td>
              <td>Object id</td>
              <td><p>Slips claim id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "claim_slip_id" : "eyJ0eXAiOiJKV1Q",
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>22. Cedants(Insurance company) - List of claim slips</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">URL - /api/ins/list_claim_slips/:cedants_id</span></code>
        <code><span class="pln">For ex - /api/ins/list_claim_slips/vdf14t5ggfg77rert</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>cedants_id</td>
              <td>Object Id</td>
              <td><p>Cedants id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "list_claim" : claim list array,
                            "claim_cases" : claim cases array
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>23. Cedants(Insurance company) - View detail of claim slip</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">URL - /api/ins/view_claim_slip/:claim_slip_id</span></code>
        <code><span class="pln">For ex - /api/ins/view_claim_slip/vdf14t5ggfg77rert</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>claim_slip_id</td>
              <td>Object Id</td>
              <td><p>Slips claim id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "claim_slip_detail" : claim slip data object,
                            "claim_cases" : claim cases objects
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>24. Cedants(Insurance company) - Create/Update claim slip</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="post" style="">
        <code><span class="pln">Create URL - /api/ins/create_claim_slip</span></code>
        <code><span class="pln">Update URL - /api/ins/update_claim_slip</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>file</td>
              <td>file(xslx)</td>
              <td><p>Upload a excel file having slips data and case data. Parameters
                      required in the excel are mentioned below:-
                  </p></td>
          </tr>
          <tr>
              <td>reference</td>
              <td>String</td>
              <td><p>Reference</p></td>
          </tr>
          <tr>
              <td>cedants_id</td>
              <td>Object Id</td>
              <td><p>Cedant id</p></td>
          </tr>
          <tr>
              <td>cedants_type_id</td>
              <td>Object Id</td>
              <td><p>Cedant type id</p></td>
          </tr>
          <tr>
              <td>reinsurances_id</td>
              <td>Object Id</td>
              <td><p>Reinsurances id</p></td>
          </tr>
          <tr>
              <td>edited_period</td>
              <td>String</td>
              <td><p>Period</p></td>
          </tr>
          <tr>
              <td>case_id (Only in case of update claim slip)</td>
              <td>Object Id (hidden)</td>
              <td><p>Slip case id</p></td>
          </tr>
          <tr>
              <td>claim_slip_id (Only in case of update claim slip)</td>
              <td>Object Id (hidden)</td>
              <td><p>Slips claim id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "claim_slip_id" : 'ffdf454fsdtt'
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>25. Cicare(Reinsurance) - Add/Update comments case wise</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="post" style="">
        <code><span class="pln">Add URL - /api/reins/add_comment</span></code>
        <code><span class="pln">Update URL - /api/reins/update_comment</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>message</td>
              <td>string</td>
              <td><p>Message</p></td>
          </tr>
          <tr>
              <td>cases_id</td>
              <td>Object Id</td>
              <td><p>Slips case id</p></td>
          </tr>
          <tr>
              <td>cases_type</td>
              <td>String</td>
              <td><p>Slips claim type</p></td>
          </tr>
          <tr>
              <td>user_reinsurance_id</td>
              <td>Object Id</td>
              <td><p>User reinsurance id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "comment_id" : comment_id
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>26. Insurance Company - Add/Update comments case wise</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="post" style="">
        <code><span class="pln">Add URL - /api/ins/add_comment</span></code>
        <code><span class="pln">Update URL - /api/ins/update_comment</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>message</td>
              <td>string</td>
              <td><p>Message</p></td>
          </tr>
          <tr>
              <td>cases_id</td>
              <td>Object Id</td>
              <td><p>Slips case id</p></td>
          </tr>
          <tr>
              <td>cases_type</td>
              <td>String</td>
              <td><p>Slips claim type</p></td>
          </tr>
          <tr>
              <td>user_cedant_id</td>
              <td>Object Id</td>
              <td><p>User cedant id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "comment_id" : comment_id
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>27. Cicare (Reinsurance) - Add/Update branch</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="post" style="">
        <code><span class="pln">Add URL - /api/reins/create_branch</span></code>
        <code><span class="pln">Update URL - /api/reins/update_branch</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>name</td>
              <td>string</td>
              <td><p>Name of branch</p></td>
          </tr>
          <tr>
              <td>max_risk_capacity</td>
              <td>String</td>
              <td><p>Maximum risk capacity</p></td>
          </tr>
          <tr>
              <td>reinsurances_id</td>
              <td>Object Id</td>
              <td><p>Reinsurance id</p></td>
          </tr>
          <tr>
              <td>branches_categories_id</td>
              <td>Object Id</td>
              <td><p>Branch categories id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "branch_id" : branch_id
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>28. Cicare (Reinsurance) - View premium/claim slip comments</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">URL - /api/reins/view_premium_comments/:premium_slip_id/:case_id</span></code>
        <code><span class="pln">URL - /api/reins/view_claim_comments/:claim_slip_id/:case_id</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>premium_slip_id (in case when slip is premium)</td>
              <td>Object Id</td>
              <td><p>Premium Slip id</p></td>
          </tr>
          <tr>
              <td>claim_slip_id (in case when slip is claim)</td>
              <td>Object Id</td>
              <td><p>Claim Slip id</p></td>
          </tr>
          <tr>
              <td>case_id</td>
              <td>Object Id</td>
              <td><p>Slip case id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "premium_slip_detail" : premium slip detail array,
                            "premium_case_comments" : premium case comments array

                            or

                            "claim_slip_detail" : claim slip detail array,
                            "claim_case_comments" : claim case comments array
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>29. Cicare(Reinsurance) Country - Create/Update</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="post" style="">
        <code><span class="pln">CREATE URL - /api/reins/create_country</span></code>
        <code><span class="pln">UPDATE URL - /api/reins/update_country</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>name</td>
              <td>String</td>
              <td><p>Name of country</p></td>
          </tr>
          <tr>
              <td>code</td>
              <td>String</td>
              <td><p> Code of country</p></td>
          </tr>
          <tr>
              <td>regions_id</td>
              <td>Object Id</td>
              <td><p>Region id</p></td>
          </tr>
          <tr>
              <td>country_id (Only in case of update country)</td>
              <td>Object Id (hidden)</td>
              <td><p>Country ID</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "country_id" : country_id,
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>30. Cicare(Reinsurance) - Check final premium slip</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">URL - /api/reins/check_final_premium_slip/:validation_status/:premium_slip_id</span></code>
        <code><span class="pln">For ex - /api/reins/check_final_premium_slip/1/vdf14t5ggfg77rert/uyuyy7585mfmf</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>validation_status</td>
              <td>Boolean(0/1)</td>
              <td><p>Validation Status of the slip where 0 indicates Rejected and 1 indicates Verified</p></td>
          </tr>
          <tr>
              <td>premium_slip_id</td>
              <td>Object id</td>
              <td><p>Premium slip id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "slipes_prime_id" : "eyJ0eXAiOiJKV1Q",
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>31. Cicare(Reinsurance) - Check final validation premium slips</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">URL - /api/reins/check_final_validation_premium_slips/:reinsurances_id</span></code>
        <code><span class="pln">For ex - /api/reins/check_final_validation_premium_slips/vdf14t5ggfg77rert/uyuyy7585mfmf</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>reinsurances_id</td>
              <td>Object id</td>
              <td><p>Reinsurance id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "slip_id" : "eyJ0eXAiOiJKV1Q",
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>32. Cicare(Reinsurance) - Get validated premium slips</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">URL - /api/reins/list_cedant_validated_premium_slips/:reinsurances_id/:cedants_id</span></code>
        <code><span class="pln">For ex - /api/reins/list_cedant_validated_premium_slips/vdf14t5ggfg77rert/uyuyy7585mfmf/dfgfdgdgg53gghgd</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>reinsurances_id</td>
              <td>Object id</td>
              <td><p>Reinsurance id</p></td>
          </tr>
          <tr>
              <td>cedants_id</td>
              <td>Object id</td>
              <td><p>Cedant id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "list_slip_array" : array of premium slips and their cases,
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>33. Cicare(Reinsurance) - Check final claim slip</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">URL - /api/reins/check_final_claim_slip/:validation_status/:claim_slip_id</span></code>
        <code><span class="pln">For ex - /api/reins/check_final_claim_slip/1/vdf14t5ggfg77rert/uyuyy7585mfmf</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>validation_status</td>
              <td>Boolean(0/1)</td>
              <td><p>Validation Status of the slip where 0 indicates Rejected and 1 indicates Verified</p></td>
          </tr>
          <tr>
              <td>cedants_id</td>
              <td>Object id</td>
              <td><p>Cedant id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "slipes_claims_id" : id,
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>34. Cicare(Reinsurance) - Check final validation claim slips</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">URL - /api/reins/check_final_validation_claim_slips/:reinsurances_id</span></code>
        <code><span class="pln">For ex - /api/reins/check_final_validation_claim_slips/vdf14t5ggfg77rert/uyuyy7585mfmf</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>reinsurances_id</td>
              <td>Object id</td>
              <td><p>Reinsurance id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "slip_id" : Slip Id,
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>35. Cicare(Reinsurance) - Get list of validated claim slips</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">URL - /api/reins/list_cedant_validated_claim_slips/:reinsurances_id/:cedants_id</span></code>
        <code><span class="pln">For ex - /api/reins/list_cedant_validated_claim_slips/vdf14t5ggfg77rert/uyuyy7585mfmf/dfgfdgdgg53gghgd</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>reinsurances_id</td>
              <td>Object id</td>
              <td><p>Reinsurance id</p></td>
          </tr>
          <tr>
              <td>cedants_id</td>
              <td>Object id</td>
              <td><p>Cedant id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "list_slip_array" : array of claim slips and their cases,
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>36. Cicare(Reinsurance) - Create/Update credit note</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="post" style="">
        <code><span class="pln">URL - /api/reins/save_credit_note</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>reinsurances_id</td>
              <td>Object Id</td>
              <td><p>Reinsurance company id</p></td>
          </tr>
          <tr>
              <td>selected_slips</td>
              <td>Array of slip ids</td>
              <td><p>Array of selected slips</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "slip_id" : "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUz",
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>37. Cicare(Reinsurance) - Create/Update debit note</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="post" style="">
        <code><span class="pln">URL - /api/reins/save_debit_note</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>reinsurances_id</td>
              <td>Object Id</td>
              <td><p>Reinsurance company id</p></td>
          </tr>
          <tr>
              <td>selected_slips</td>
              <td>Array of slip ids</td>
              <td><p>Array of selected slips</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "slip_id" : "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUz",
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>38. Cicare(Reinsurance) - Create/Update note comment</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="post" style="">
        <code><span class="pln">Create URL - /api/reins/add_note_comment</span></code>
        <code><span class="pln">Update URL - /api/reins/update_note_comment</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>message</td>
              <td>String</td>
              <td><p>Message</p></td>
          </tr>
          <tr>
              <td>user_reinsurance_id</td>
              <td>Object Id</td>
              <td><p>Reinsurance user id</p></td>
          </tr>
          <tr>
              <td>comment_id (only in case of update)</td>
              <td>Object Id</td>
              <td><p>Comment Id</p></td>
          </tr>
          <tr>
              <td>note_id (only in case of create)</td>
              <td>Object Id</td>
              <td><p>Note Id</p></td>
          </tr>
          <tr>
              <td>note_type (only in case of create)</td>
              <td>String</td>
              <td><p>Type of note - credit or debit</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "comment_id" : "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUz",
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>39. Insurance company (Cedant) - Create/Update note comment</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="post" style="">
        <code><span class="pln">Create URL - /api/ins/add_note_comment</span></code>
        <code><span class="pln">Update URL - /api/ins/update_note_comment</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>message</td>
              <td>String</td>
              <td><p>Message</p></td>
          </tr>
          <tr>
              <td>user_cedant_id</td>
              <td>Object Id</td>
              <td><p>Cedant user id</p></td>
          </tr>
          <tr>
              <td>comment_id (only in case of update)</td>
              <td>Object Id</td>
              <td><p>Comment Id</p></td>
          </tr>
          <tr>
              <td>note_id (only in case of create)</td>
              <td>Object Id</td>
              <td><p>Note Id</p></td>
          </tr>
          <tr>
              <td>note_type (only in case of create)</td>
              <td>String</td>
              <td><p>Type of note - credit or debit</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "comment_id" : "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUz",
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>40. Cicare (Reinsurance) - Get list of cedants</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">Create URL - /api/reins/list_cedants/:reinsurances_id</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>reinsurances_id</td>
              <td>Object Id</td>
              <td><p>Reinsurance company id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "cedants array" : Array of cedants,
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>41. Cicare (Reinsurance) - Get list of branches</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">Create URL - /api/reins/list_branches/:reinsurances_id</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>reinsurances_id</td>
              <td>Object Id</td>
              <td><p>Reinsurance company id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "branches array" : Array of branches,
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>42. Cicare (Reinsurance) - List debit notes</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">Create URL - /api/reins/list_debit_notes/:reinsurances_id</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>reinsurances_id</td>
              <td>Object Id</td>
              <td><p>Reinsurance company id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "list_debit_notes array" : array of debit notes,
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>43. Cicare (Reinsurance) - List credit notes</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">Create URL - /api/reins/list_credit_notes/:reinsurances_id</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>reinsurances_id</td>
              <td>Object Id</td>
              <td><p>Reinsurance company id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "list_credit_notes array" : array of credit notes,
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>44. Cicare (Reinsurance) - Check final note</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">Create URL - /api/reins/check_final_note/:validation_status/:note_id</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>validation_status</td>
              <td>Boolean(0 or 1)</td>
              <td><p>0 stands for Rejected and 1 stands for Verified</p></td>
          </tr>
          <tr>
              <td>note_id</td>
              <td>Object Id</td>
              <td><p>Note Id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "note_id" : "gdgd56ghg646hhh",
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>45. Cicare (Reinsurance) -Check final payment status of note</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">Create URL - /api/reins/check_final_payment_note/:payment_status/:note_id</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>payment_status</td>
              <td>String</td>
              <td><p>It can be fully paid or partially paid</p></td>
          </tr>
          <tr>
              <td>note_id</td>
              <td>Object Id</td>
              <td><p>Note id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "list_credit_notes array" : array of credit notes,
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>46. Insurance company (Cedant) - List debit notes</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">Create URL - /api/ins/list_debit_notes/:cedants_id</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>cedants_id</td>
              <td>Object Id</td>
              <td><p>Insurance company id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "list_debit_notes array" : array of debit notes,
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>47. Insurance company (Cedant) - List credit notes</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">Create URL - /api/ins/list_credit_notes/:cedants_id</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>cedants_id</td>
              <td>Object Id</td>
              <td><p>Insurance company id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "list_credit_notes array" : array of credit notes,
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>48. Insurance company (Cedant) - Check final note</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">Create URL - /api/ins/check_final_note/:approval_status/:note_id</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>approval_status</td>
              <td>Boolean(0 or 1)</td>
              <td><p>0 stands for Rejected and 1 stands for Verified</p></td>
          </tr>
          <tr>
              <td>note_id</td>
              <td>Object Id</td>
              <td><p>Note Id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "note_id" : "gdgd56ghg646hhh",
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>30. Cicare(Reinsurance) Forgot Password - Email/Reset</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="post" style="">
        <code><span class="pln">EMAIL URL - /api/reins/password_email</span></code>
        <code><span class="pln">RESET URL - /api/reins/password_reset</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>No</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>email (Only in case of email url)</td>
              <td>String</td>
              <td><p>User Email</p></td>
          </tr>
          <tr>
              <td>password</td>
              <td>string</td>
              <td><p>User Password</p></td>
          </tr>
          <tr>
            <td>password_confirmation</td>
            <td>String</td>
            <td><p>User Password Confirmation</p></td>
            </tr>
          <tr>
              <td>token</td>
              <td>String</td>
              <td><p>Token getting after sending the email (email url) </p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>31. Insurance Company Forgot Password - Email/Reset</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="post" style="">
        <code><span class="pln">EMAIL URL - /api/ins/password_email</span></code>
        <code><span class="pln">RESET URL - /api/ins/password_reset</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>No</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>email (Only in case of email url)</td>
              <td>String</td>
              <td><p>User Email</p></td>
          </tr>
          <tr>
              <td>password</td>
              <td>string</td>
              <td><p>User Password</p></td>
          </tr>
          <tr>
            <td>password_confirmation</td>
            <td>String</td>
            <td><p>User Password Confirmation</p></td>
            </tr>
          <tr>
              <td>token</td>
              <td>String</td>
              <td><p>Token getting after sending the email (email url) </p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>32. Cicare (Reinsurance) - Automatic warning for premium slip(NOT LIFE AND LIFE COMPANY)-System calculation</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">URL - /api/reins/warning_premium_iard_calculation/:premium_slip_id</span></code>
        <code><span class="pln">URL - /api/reins/warning_premium_life_calculation/:premium_slip_id</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>premium_slip_id (in case when slip is premium)</td>
              <td>Object Id</td>
              <td><p>Premium Slip id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "premium_slip_case_error" : premium slip case error detail array",
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>33. Cicare (Reinsurance) - Automatic warning for premium slip(NOT LIFE AND LIFE COMPANY)-check for warning</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">URL - /api/reins/warning_premium_iard_coinsurance/:premium_slip_id</span></code>
        <code><span class="pln">URL - /api/reins/warning_premium_life_coinsurance/:premium_slip_id</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>premium_slip_id (in case when slip is premium)</td>
              <td>Object Id</td>
              <td><p>Premium Slip id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "premium_slip_case_coinsurance" : premium slip case co-insurance detail array",
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>34. Cicare (Reinsurance) - Automatic warning for claim slip(LIFE COMPANY)-System calculation</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">URL - /api/reins/warning_claim_life_calculation/{claim_slip_id}</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>claim_slip_id (in case when slip is claim)</td>
              <td>Object Id</td>
              <td><p>Claim Slip id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "claim_slip_case_error" : claim slip case error detail array",
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>

  <article>
    <div class="pull-left">
      <h1>35. Cicare (Reinsurance) - Automatic warning for claim slip(LIFE COMPANY AND NOT LIFE COMPANY)-integrity check for warning</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="get" style="">
        <code><span class="pln">URL - /api/reins/warning_claim_check/{claim_slip_id}</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>claim_slip_id (in case when slip is claim)</td>
              <td>Object Id</td>
              <td><p>Claim Slip id</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "claim_slip_case_life_check" : [
                                {
                                    "case_id": "5d54adf4209434502e994fc1",
                                    "message": "claim_number_double"
                                }
                                    .................
                                    ............

                                ],

                                OR

                            "claim_slip_case_no_life_check" : [
                                {
                                    "case_id": "5d54adf4209434502e994fc1",
                                    "message": "claim_number_double"
                                }
                                    .................
                                    ............

                                ],

                            "claim_slip_detail": {
                                    "_id": "5d54af87209434502e994ff2",
                                    "cedants_id": "",
                                    "created_on": "",
                                    "edited_period": "",
                                    "reference": "",
                                    "updated_on": "",
                                    "cedants_type_id": "5d54a8f4717d9543774d1f9f"
                                }
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>
  <article>
    <div class="pull-left">
      <h1>36. Cicare(Reinsurance) - Create/Update countries</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="post" style="">
        <code><span class="pln">CREATE URL - /api/reins/create_country</span></code>
        <code><span class="pln">UPDATE URL - /api/reins/update_country</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 10%">Type</th>
            <th style="width: 60%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>name</td>
              <td>String</td>
              <td><p>Name of the countrie</p></td>
          </tr>
          <tr>
              <td>Code</td>
              <td>String</td>
              <td><p>Code of countrie</p></td>
          </tr>
         <tr>
              <td>Region_id</td>
              <td>Object Id</td>
              <td><p>Code of countrie region</p></td>
          </tr>
        <tr>
              <td>Countrie_id</td>
              <td>Object Id</td>
              <td><p>Code of countrie</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "name" : "Togo",
                            "code" : "TG",
                            "region_id" : "aCjhoiOOJHGD",
                            "countrie_id" : "eyJ0eXAiOiJKV1Q",
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>
  <article>
    <div class="pull-left">
      <h1>37. Cicare(Reinsurance) - Create/Update payment method</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="post" style="">
        <code><span class="pln">CREATE URL - /api/reins/create_payment_method</span></code>
        <code><span class="pln">UPDATE URL - /api/reins/update_payment_method</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 10%">Type</th>
            <th style="width: 60%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>name</td>
              <td>String</td>
              <td><p>Name of the payment method</p></td>
          </tr>
          
        <tr>
              <td>payment_method_id</td>
              <td>Object Id</td>
              <td><p>Id of existing payment method(only in case of update)</p></td>
          </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => true,
                        'data'    => [
                            "name" : "Abfgh",
                            "payment_method_id" : "eyJ0eXAiOiJKV1Q",
                        ],
                        'message' => 'success message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>


  <article>
    <div class="pull-left">
      <h1>38. Cicare(Reinsurance) Credit Note Management - Edit</h1>
    </div>
    <div class="clearfix"></div>

    <pre class="prettyprint language-html prettyprinted" data-type="post" style="">
        <code><span class="pln">EDIT URL - /api/reins/edit_credit_note</span></code>
    </pre>
      <h2>Token</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 10%">Required</th>
            <th style="width: 20%">Field</th>
            <th style="width: 20%">Type</th>
            <th style="width: 50%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>Yes</td>
              <td>token</td>
              <td>Bearer type (Authorization)</td>
              <td><p>Token returned from login</p></td>
          </tr>
        </tbody>
      </table>

      <h2>Parameter</h2>
      <table>
        <thead>
          <tr>
            <th style="width: 30%">Field</th>
            <th style="width: 10%">Type</th>
            <th style="width: 60%">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <td>credit_note_id (required)</td>
              <td>Object Id</td>
              <td><p>Id of the credit note</p></td>
          </tr>
          <tr>
              <td>location</td>
              <td>String</td>
              <td><p>Location of credit note</p></td>
          </tr>
         <tr>
              <td>date</td>
              <td>Date</td>
              <td><p>Date of credit note</p></td>
          </tr>
        <tr>
              <td>periodicity</td>
              <td>String</td>
              <td><p>Periodicity of credit note</p></td>
          </tr>
        <tr>
            <td>year</td>
            <td>String</td>
            <td><p>Year of credit note</p></td>
        </tr>
        <tr>
            <td>type</td>
            <td>String</td>
            <td><p>Type of credit note</p></td>
        </tr>
        <tr>
            <td>slip_ids</td>
            <td>Array</td>
            <td><p>Slip ids of credit note</p></td>
        </tr>
        <tr>
            <td>note_url</td>
            <td>String</td>
            <td><p>Note url of credit note</p></td>
        </tr>
        <tr>
            <td>payment_status</td>
            <td>String</td>
            <td><p>Payment status of credit note</p></td>
        </tr>
        <tr>
            <td>validation_status</td>
            <td>String</td>
            <td><p>Validation status of credit note</p></td>
        </tr>
        <tr>
            <td>approval_status</td>
            <td>String</td>
            <td><p>Approval status of credit note</p></td>
        </tr>
        </tbody>
      </table>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#success-examples">Success-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="success-examples">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    {
                        "success": true,
                        "data": {
                            "_id": "XXXXXXXXXXXXXXXXXXXXXX",
                            "approval_status": "Pending",
                            "cedants_id": "XXXXXXXXXXXXXXXXX",
                            "created_at": "2019-09-13 10:18:40",
                            "date": "13Sep2019",
                            "ins_type": "LIFE",
                            "location": "",
                            "note_url": "XXXXXXXXXXXXXXXXX",
                            "payment_status": "Pending",
                            "periodicity": "third trimester",
                            "reference": "XXXXXXXXX",
                            "reinsurances_id": "5d5e8329f873e7ccdb577890",
                            "slip_ids": [
                                "XXXXXXXXXXXXXXXXXXXXX"
                            ],
                            "slip_total": [
                                5
                            ],
                            "type": "credit",
                            "updated_at": "2019-10-04 15:53:45",
                            "validation_status": "Verified",
                            "year": "2020"
                        },
                        "message": "Credit note edited successfully"
                    }
                </span>
            </code>
        </pre>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-examples">
          <li class="active">
            <a href="#error-examples">Error-Response:</a>
          </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="error-examples-User-GetUser-0_2_0-0">
        <pre class="prettyprint language-json prettyprinted" data-type="json" style="">
            <code>
                <span class="">
                    [
                        'success' => false,
                        'message' => 'error message',
                    ]
                </span>
            </code>
        </pre>
        </div>
      </div>

  </article>


</div>
