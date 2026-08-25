<script>
    //remove shortlist
        function removeshortlist(matri_id){
            var registerId = matri_id;
            $.ajax({
                url: "{{ route('user.shortlistremove') }}",
                type: "POST",
                data: {
                    register_id: registerId,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function (result) {
                    $('#removeshortlist').toast('show');
                     $("#reshow" + registerId).show();
                    $("#remove" + registerId).hide();
                    $("#removedata"  + registerId).hide();
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        //add shortlist
        function addshortlist(matri_id){
            var registerId = matri_id;
            $.ajax({
                url: "{{ route('user.shortliststore') }}",
                type: "POST",
                data: {
                    register_id: registerId,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function (result) {
                    $('#shortlist').toast('show');
                     $("#reshow" + registerId).hide();
                    $("#remove" + registerId).show();
                    $("#reshowdata"  + registerId).hide();
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        //remove intrest
        function removeintrest(matri_id){
            var registerId = matri_id;
            $.ajax({
                url: "{{ route('user.interestremove') }}",
                type: "POST",
                data: {
                    register_id: registerId,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function (result) {
                    $('#removeintrest').toast('show');
                     $("#sendintrest" + registerId).show();
                    $("#removeintrest" + registerId).hide();
                    $("#interestremovedata"  + registerId).hide();
                    
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        //add intrest
         function sendintrest(matri_id){
            var registerId = matri_id;
            $.ajax({
                url: "{{ route('user.intereststore') }}",
                type: "POST",
                data: {
                    register_id: registerId,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function (result) {
                    $('#sendintrest').toast('show');
                    $("#removeintrest" + registerId).show();
                    $("#sendintrest" + registerId).hide();
                    $("#interestshowdata"  + registerId).hide();
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        //add ignor
        function ignore(matri_id){
            var registerId = matri_id;
            $.ajax({
                url: "{{ route('user.ignore') }}",
                type: "POST",
                data: {
                    register_id: registerId,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function (result) {
                    $('#addignore').toast('show');
                     $("#unignore" + registerId).show();
                    $("#ignore" + registerId).hide();
                    $("#ignoredata" + registerId).hide();
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        //remove ignor
        function unignore(matri_id){
            var registerId = matri_id;
            $.ajax({
                url: "{{ route('user.unignore') }}",
                type: "POST",
                data: {
                    register_id: registerId,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function (result) {
                    $('#removeignore').toast('show');
                     $("#ignore" + registerId).show();
                    $("#unignore" + registerId).hide();
                    $("#unignoredata" + registerId).hide();
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
 
</script>