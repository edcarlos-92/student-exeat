  </div>
  <!-- /.container-fluid -->

  <!-- Sticky Footer -->
  <footer class="sticky-footer">
      <div class="container my-auto">
          <div class="copyright text-center my-auto">
              <span>Copyright © Student Exeat Management System</span>
          </div>
      </div>
  </footer>

  </div>
  <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                  </button>
              </div>
              <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
              <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                  <a class="btn btn-primary" href="../../index.php">Logout</a>
              </div>
          </div>
      </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="../../vendor/jquery/jquery.min.js"></script>
  <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="../../vendor/chart.js/Chart.min.js"></script>
  <script src="../../vendor/datatables/jquery.dataTables.js"></script>
  <script src="../../vendor/datatables/datatables.min.js"></script>
  <script src="../../vendor/datatables/dataTables.fixedColumns.min.js"></script>

  <script src="../../vendor/jqueryUI/jquery-ui.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="../../js/sb-admin.min.js"></script>
  <script src="../../js/adminpanel.js"></script>


  <!-- Bootstrap Datatables-->


  </body>
  <script>
$(document).ready(function() {
    $(".datepicker").datepicker({
        dateFormat: 'yy-mm-dd'
    });
});
  </script>
  <script>
$(document).ready(function() {
    var table = $('#dataTable').DataTable({
        searching: false,
        paging: false,
        info: false,
        fixedHeader: {
            header: true,
            footer: true
        },
        columnDefs: [{
            "orderable": false,
            "targets": 0
        }],
        scrollX: true,
        scrollCollapse: true,
        fixedColumns: {
            leftColumns: 1,
            /*rightColumns: 1 // If you want fixed Action column*/
        }
    });

    $('.checkAll').on('change', function() {
        if ($(this).is(':checked')) {
            $('.checkRow').attr('checked', true);
        } else {
            $('.checkRow').removeAttr('checked');
        }
    });
});
  </script>
  <script type="text/javascript">
function imageUpload(controlID) {
    var baseURL = <?php echo "'" . $baseurl . "'" ?>;
    var fd = new FormData();
    var names = [];
    var file_data = $('#' + controlID + 'File').prop("files");
    for (var i = 0; i < file_data.length; i++) {
        fd.append("file_" + i, file_data[i]);
    }
    fd.append('file[]', names);
    $.ajax({
        url: <?php echo "'" . $baseurl . "app/media_upload/multiple_upload.php'"; ?>,
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        success: function(response) {
            if (response && response.code == 1) {

                if (document.getElementById(controlID).value.length <= 0) {
                    document.getElementById(controlID).value = response.document.replace(/(^\s*,)|(,\s*$)/g,
                        '');
                } else {
                    document.getElementById(controlID).value += response.document;
                }
                var imgArray = response.document.replace(/(^\s*,)|(,\s*$)/g, '');
                imgArray.split(',').forEach(function(r) {
                    var imageBox = '<div class="col-xs-2 col-md-1 px-0" id="' + r + '">';
                    imageBox = imageBox + '<div class="artist-collection-photo">';
                    imageBox = imageBox + '<div><button onClick="removeImage(\'' + controlID +
                        '\',\'' + r + '\');" class="close" type="button">×</button></div>';
                    imageBox = imageBox + '<a href="' + baseURL + 'app/media_upload/upload/' + r +
                        '" target="_blank" >';
                    imageBox = imageBox + '<img src="' + baseURL + 'app/media_upload/upload/' + r +
                        '" class="img-thumbnail" style="width:100px;height:100px"/>';
                    imageBox = imageBox + '</a></div></div>';
                    $("#" + controlID + "_List").append(imageBox);
                });
            } else {
                alert("Image upload failed, Please try again");
            }
        },
        error: function(response) {
            alert('error : ' + JSON.stringify(response));
        }
    });
}

function removeImage(controlID, imageId) {
    document.getElementById(controlID).value = document.getElementById(controlID).value.replace(imageId, "");
    document.getElementById(controlID).value = document.getElementById(controlID).value.replace(/(^\s*,)|(,\s*$)/g, '');
    var elem = document.getElementById(imageId);
    elem.parentElement.removeChild(elem);
}

function pdfUpload(controlID) {
    var baseURL = <?php echo "'" . $baseurl . "'" ?>;
    var fd = new FormData();
    var names = [];
    var file_data = $('#' + controlID + 'File').prop("files");
    for (var i = 0; i < file_data.length; i++) {
        fd.append("file_" + i, file_data[i]);
    }
    fd.append('file[]', names);
    $.ajax({
        url: <?php echo "'" . $baseurl . "app/media_upload/multiple_file.php'"; ?>,
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        success: function(response) {
            if (response && response.code == 1) {

                if (document.getElementById(controlID).value.length <= 0) {
                    document.getElementById(controlID).value = response.document.replace(/(^\s*,)|(,\s*$)/g,
                        '');
                } else {
                    document.getElementById(controlID).value += response.document;
                }
                var imgArray = response.document.replace(/(^\s*,)|(,\s*$)/g, '');
                imgArray.split(',').forEach(function(r) {
                    var imageBox = '<div class="col-xs-2 col-md-1 px-0" id="' + r + '">';
                    imageBox = imageBox + '<div class="artist-collection-photo">';
                    imageBox = imageBox + '<div><button onClick="removePDF(\'' + controlID +
                        '\',\'' + r + '\');" class="close" type="button">×</button></div>';
                    imageBox = imageBox + '<a href="' + baseURL + 'app/media_upload/pdf/' + r +
                        '" target="_blank" >';
                    imageBox = imageBox + '<img src="' + baseURL +
                        'images/pdficon.png" class="img-thumbnail" style="width:100px;height:100px"/>';
                    imageBox = imageBox + '</a></div></div>';
                    $("#" + controlID + "_List").append(imageBox);
                });
            } else {
                alert("Image upload failed, Please try again");
            }
        },
        error: function(response) {
            alert('error : ' + JSON.stringify(response));
        }
    });
}

function removePDF(controlID, pdfID) {
    document.getElementById(controlID).value = document.getElementById(controlID).value.replace(imageId, "");
    document.getElementById(controlID).value = document.getElementById(controlID).value.replace(/(^\s*,)|(,\s*$)/g, '');
    var elem = document.getElementById(pdfID);
    elem.parentElement.removeChild(elem);
}
  </script>

  </html>