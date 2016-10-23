<!DOCTYPE html>
<html>
<head>
    <title>Devcon Push Notification Demo</title>
    <link rel="manifest" href="manifest.json">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./css/main.css">
</head>
<body>
    <div class="well row">
        <div class="col-md-6">
            <h1> Subscribe/Unsubscribe here: 
                <button type="button" class="btn btn-primary" id="unsubscribe-push-notification" 
                data-dismiss="modal">Unsubscribe</button>
               <button type="button" class="btn btn-primary subscribe-push-notification hidden" 
                id="subscribe-push-notification" data-dismiss="modal">Subscribe</button>
            </h1>
        </div>
    </div>

    <div class="main-body row">
        <div class="col-md-8">
            <h1>Send yourself a notification</h1>
            <form>
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" id="title">
                </div>
                <div class="form-group">
                    <label for="body">Body:</label>
                    <textarea class="form-control" id="body" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label for="url">Url:</label>
                    <input type="text" class="form-control" id="url">
                </div>
                <button type="button" id="send-notification-btn" class="btn btn-primary">Send</button>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div id="push-notification-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Enable Push Notification</h4>
                </div>
                <div class="modal-body">
                    <p>Do you want to receive push notifications from this site?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary subscribe-push-notification"  
                    data-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </div>
          </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.1.1.js" integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA="  crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./js/main.js"></script>
</body>
</html>