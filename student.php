<?php session_start();

include_once 'database.php';
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'Teacher') {
  # code...
  header('Location:./logout.php');
}

$sid = $fname = $lname = $classroom = $dob = $gender = $address = $parent = " ";

if (isset($_GET['update'])) {
  $update = "SELECT * FROM student WHERE sid='" . $_GET['update'] . "'";
  $result = $conn->query($update);

  if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
      $sid = $row['sid'];
      $fname = $row['fname'];
      $lname = $row['lname'];
      $classroom = $row['classroom'];
      $email = $row['email'];
      $dob = date_format(new DateTime($row['bday']), 'm/d/Y');
      //echo $dob;
      $gender = $row['gender'];
      $address = $row['address'];
      $parent = $row['parent'];
    }
  }
}
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SGE - Sistema Gerenciador de Escolas - Estudantes</title>
  <link rel="icon" href="../img/favicon2.png">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-green sidebar-mini">
  <div class="wrapper">

    <!-- Main Header -->
    <?php include_once './header.php'; ?>
    <!-- Left side column. contains the logo and sidebar -->
    <?php include_once './sidebar.php'; ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Estudante
          <small>Detalhes</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Estudante</a></li>
          <li class="active">Detalhes</li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <?php if (!isset($_GET['update'])) { ?>
            <div class="col-xs-4">
              <div class="alert alert-success alert-dismissible" style="display: none;" id="truemsg">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Sucesso!</h4>
                Novo aluno adicionado com sucesso
              </div>
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Novo Estudante</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="POST">
                  <div class="box-body">

                    <div class="form-group">
                      <label for="exampleInputPassword1">Matrícula</label>
                      <input name="sid" type="text" class="form-control" id="exampleInputPassword1" placeholder="Identificação" required>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputPassword1">Nome</label>
                      <input name="fname" type="text" class="form-control" id="exampleInputPassword1" placeholder="Primeiro Nome" required>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputPassword1">Sobrenome</label>
                      <input name="lname" type="text" class="form-control" id="exampleInputPassword1" placeholder="Sobrenome" required>
                    </div>

                    <div class="form-group">
                      <label>Data de Nascimento</label>
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" name='dob' class="form-control pull-right" id="datepicker" placeholder="Selecione a Data de Nascimento">
                      </div>
                      <!-- /.input group -->
                    </div>

                    <div class="form-group">
                      <label for="exampleInputPassword1">Sexo</label>
                      <div class="radio ">
                        <label style="width: 100px"><input type="radio" name="gender" value="Male" checked>Masculino</label>
                        <label style="width: 100px"><input type="radio" name="gender" value="Female" checked>Feminino</label>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputPassword1">Email</label>
                      <input name="email" type="email" class="form-control" id="exampleInputPassword1" placeholder="Endereço de email" required>
                    </div>


                    <div class="form-group">
                      <label for="exampleFormControlTextarea1">Endereço</label>
                      <textarea name="address" class="form-control" id="exampleFormControlTextarea1" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                      <label>Sala de Aula</label>
                      <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="classroom">
                        <option>Selecione a Sala de Aula</option>
                        <?php
                        $sql = "SELECT * FROM classroom";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                          // output data of each row
                          while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["hno"] . "' >" . $row["title"] . "_ID:" . $row["hno"] . "</option>";
                          }
                        }
                        ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label>Responsável</label>
                      <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="parent">
                        <option value="0">Selecione o Responsável</option>
                        <?php

                        $sql = "SELECT * FROM parent";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                          // output data of each row
                          while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["pid"] . "' >" . $row["fname"] . " " . $row["lname"] . " - ID:" . $row["pid"] . "</option>";
                          }
                        }

                        ?>
                      </select>
                    </div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary">Adicionar Estudante</button>
                  </div>
                </form>

                <?php
                if (isset($_POST['submit'])) {
                  $sid = $_POST['sid'];
                  $fname = $_POST['fname'];
                  $lname = $_POST['lname'];
                  $email = $_POST['email'];
                  $classroom = $_POST['classroom'];

                  $dob = date_format(new DateTime($_POST['dob']), 'Y-m-d');
                  //echo $dob;
                  $gender = $_POST['gender'];
                  $address = $_POST['address'];
                  $parent = " ";
                  if (isset($_POST['parent'])) {
                    $parent = $_POST['parent'];
                  }
                  try {
                    $sql = "INSERT INTO student (sid,fname,lname,bday,address,gender,parent,classroom,email) VALUES ('" . $sid . "', '" . $fname . "', '" . $lname . "','" . $dob . "','" . $address . "','" . $gender . "','" . $parent . "','" . $classroom . "','" . $email . "')";

                    if ($conn->query($sql) === TRUE) {
                      echo "<script type='text/javascript'> var x = document.getElementById('truemsg');
x.style.display='block';</script>";
                    } else {
                    }
                  } catch (Exception $e) {
                  }
                  # code...
                }
                ?>
              </div>
            </div>
          <?php } elseif (isset($_GET['update'])) { ?>
            <!-- *************************** -->
            <!-- *** EDIÇÃO DE ESTUDANTE ***-->
            <!-- *************************** -->
            <div class="col-xs-4">
              <div class="alert alert-success alert-dismissible" style="display: none;" id="truemsg">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Sucesso!</h4>
                Cadastro Atualizado
              </div>
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Alteração </h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="POST">
                  <div class="box-body">

                    <div class="form-group">
                      <label for="exampleInputPassword1">Matrícula</label>
                      <input name="sid" type="text" class="form-control" id="exampleInputPassword1" required value=<?php echo "'" . $sid . "'"; ?>>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputPassword1">Nome</label>
                      <input name="fname" type="text" class="form-control" id="exampleInputPassword1" required value=<?php echo "'" . $fname . "'"; ?>>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputPassword1">Sobrenome</label>
                      <input name="lname" type="text" class="form-control" id="exampleInputPassword1" required value=<?php echo "'" . $lname . "'"; ?>>
                    </div>

                    <div class="form-group">
                      <label>Data de Nascimento</label>
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" name='dob' class="form-control pull-right" id="datepicker" placeholder="Select Student's Data of Birth" value=<?php echo "'" . $dob . "'"; ?>>
                      </div>
                      <!-- /.input group -->
                    </div>

                    <div class="form-group">
                      <label for="exampleInputPassword1">Sexo</label>
                      <div class="radio ">
                        <label style="width: 100px"><input type="radio" name="gender" value="Male" <?php if ($gender == 'Male') {
                                                                                                      echo 'checked';
                                                                                                    } ?>>Masculino</label>
                        <label style="width: 100px"><input type="radio" name="gender" value="Female" <?php if ($gender == 'Female') {
                                                                                                        echo 'checked';
                                                                                                      } ?>>Feminino</label>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputPassword1">Email</label>
                      <input name="email" type="email" class="form-control" id="exampleInputPassword1" required value=<?php echo "'" . $email . "'"; ?>>
                    </div>

                    <div class="form-group">
                      <label for="exampleFormControlTextarea1">Endereço</label>
                      <textarea name="address" class="form-control" id="exampleFormControlTextarea1" rows="2"><?php echo $address; ?></textarea>
                    </div>
                    <div class="form-group">
                      <label>Turma</label>
                      <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="classroom">
                        <option>Selecione a turma</option>
                        <?php
                        $sql = "SELECT * FROM classroom";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                          // output data of each row
                          while ($row = $result->fetch_assoc()) {
                            echo "<option ";
                            if ($classroom == $row["hno"]) {
                              echo 'selected="selected"';
                            }
                            echo " value='" . $row["hno"] . "' >" . $row["title"] . "_ID:" . $row["hno"] . "</option>";
                          }
                        }
                        ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Responsável</label>
                      <select name="parent" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                        <option value="0">Selecion o Responsável</option>
                        <?php

                        $sql = "SELECT * FROM parent";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                          // output data of each row
                          while ($row = $result->fetch_assoc()) {


                            echo "<option ";
                            if ($parent == $row["pid"]) {
                              echo 'selected="selected"';
                            }
                            echo " value='" . $row["pid"] . "' >" . $row["fname"] . " " . $row["lname"] . " - ID:" . $row["pid"] . "</option>";
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary">Atualizar Dados</button>
                  </div>
                </form>
                <?php
                if (isset($_POST['submit'])) {
                  $sid = $_POST['sid'];
                  $fname = $_POST['fname'];
                  $lname = $_POST['lname'];
                  $classroom = $_POST['classroom'];
                  $email = $_POST['email'];
                  $dob = date_format(new DateTime($_POST['dob']), 'Y-m-d');
                  //echo $dob;
                  $gender = $_POST['gender'];
                  $address = $_POST['address'];
                  $parent = $_POST['parent'];
                  try {

                    $sql = "UPDATE student set fname='" . $fname . "',lname='" . $lname . "',bday='" . $dob . "',address='" . $address . "',gender='" . $gender . "',parent=" . $parent . ",classroom='" . $classroom . "',email='" . $email . "' where sid='" . $sid . "'";

                    // $sql = "INSERT INTO student (sid,fname,lname,bday,address,gender,parent,classroom) VALUES ('".$sid."', '".$fname."', '".$lname."','".$dob."','".$address."','".$gender."','".$parent."','".$classroom."')";

                    if ($conn->query($sql) === TRUE) {
                      echo "<script type='text/javascript'> var x = document.getElementById('truemsg');
x.style.display='block';</script>";
                    } else {
                    }
                  } catch (Exception $e) {
                  }
                  # code...
                }
                ?>
              </div>
            </div>
          <?php } ?>
          <div class="col-xs-8">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Estudantes</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Matrícula</th>
                      <th>Nome</th>
                      <th>Data de Nascimento</th>
                      <th>Sexo</th>
                      <th>Endereço</th>
                      <th>Turma</th>
                      <th>Responsável</th>
                      <th>Acções</th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php

                    $sql = "SELECT * FROM student";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                      // output data of each row
                      while ($row = $result->fetch_assoc()) {
                        echo "<tr><td> " . $row["sid"] . " </td><td> " . $row["fname"] . " " . $row["lname"] . " </td><td> " . $row["bday"] . "</td><td>" . $row["gender"] . "</td><td>" . $row["address"] . "</td><td>" . $row["classroom"] . "</td><td>" . $row["parent"] . "</td><td><a href='student.php?update=" . $row["sid"] . "'><small class='label  bg-orange'>Editar</small></a></td></tr>";
                      }
                    }
                    ?>
                  </tbody>
                  <tfoot>

                  </tfoot>
                </table>
              </div>
              <!-- /.box-body -->
            </div>
          </div>
          <!-- /.box -->
        </div>
        <!--------------------------
        | Your Page Content Here |
        -------------------------->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- Main Footer -->
    <?php include_once 'footer.php'; ?>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->
  <!-- REQUIRED JS SCRIPTS -->
  <!-- jQuery 3 -->
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="bower_components/select2/dist/js/select2.full.min.js"></script>
  <!-- Select2 -->
  <script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- bootstrap color picker -->
  <script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
  <!-- bootstrap time picker -->
  <script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>

  <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <!-- iCheck 1.0.1 -->
  <script src="plugins/iCheck/icheck.min.js"></script>
  <!-- FastClick -->
  <script src="bower_components/fastclick/lib/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- Page script -->

  <script>
    $(function() {
      $('#example1').DataTable()
      $('#example2').DataTable({
        'paging': true,
        'lengthChange': false,
        'searching': false,
        'ordering': true,
        'info': true,
        'autoWidth': false
      })
    })
  </script>

  <script>
    $('.select2').select2()
    $('#datepicker').datepicker({
      autoclose: true
    });

    var r = document.getElementById("new");
    r.className += "active";
  </script>
  <!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>

</html>