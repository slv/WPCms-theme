<?php

Class WPCmsGoogleMapField Extends WPCmsField {

  public function addActionAdminEnqueueScripts ($hook)
  {
    wp_enqueue_script('gmap', 'http://maps.google.com/maps/api/js?sensor=false');
  }

  public function renderInnerInput ($post, $data = array())
  {
    $mapId = 'gmap-' . $data['id'];
    echo '<div class="gmap">';
    echo '<input type="hidden" name="', $data['name'], '" id="', $data['id'], '" value="', esc_attr($data['value']), '" size="30" />';
    echo '<div style="width:400px;height:300px;border:8px solid #eeeeee;border-radius:8px;" id="' . $mapId . '"></div>';

?>
    <script>
      jQuery(document).ready(function ($) {
        var mapOptions = {
          zoom: 9,
          mapTypeId: google.maps.MapTypeId.ROADMAP,
          center: new google.maps.LatLng(53.000,0.0005)
        }
        var map = new google.maps.Map(document.getElementById('<?php echo $mapId; ?>'), mapOptions);
        var marker;
        if ('<?php echo $data['value']; ?>' != '') {
          map.setCenter(new google.maps.LatLng(<?php echo $data['value']; ?>));
          marker = new google.maps.Marker({
            position: new google.maps.LatLng(<?php echo $data['value']; ?>),
            map: map,
            draggable: true
          });
          google.maps.event.addListener(marker, 'dragend', function () {
            $('#<?php echo $data['id']; ?>').val(marker.position.lat() + ',' + marker.position.lng());
          });
        }

        google.maps.event.addListener(map, 'click', function(event) {
          if (marker) {
            marker.setPosition(event.latLng);
          }
          else {
            marker = new google.maps.Marker({
              position: event.latLng,
              map: map,
              draggable: true
            });
            google.maps.event.addListener(marker, 'dragend', function () {
              $('#<?php echo $data['id']; ?>').val(marker.position.lat() + ',' + marker.position.lng());
            });
          }
          $('#<?php echo $data['id']; ?>').val(event.latLng.lat() + ',' + event.latLng.lng());
        });
      });
    </script>
<?php

    echo '</div>';
  }

}
