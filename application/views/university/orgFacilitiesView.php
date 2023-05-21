
<div class="col-md-4">
    <label><b>Default Facilities</b></label>
    <?php
    if (isset($orgFacilities)) {
        foreach ($orgFacilities as $fc) {
            if ($fc->mappingId) {
                echo '<div class="fac">
                <label class="checkbox-inline">
                <input checked value="' . $fc->facilityId . '" type="checkbox" name="facility[]" class="service_tax1" id="' . $fc->facilityId . '">
                ' . $fc->title . '</label> </div>   ';
            } else {
                echo '<div class="fac">
                    <label class="checkbox-inline">
                    <input value="' . $fc->facilityId . '" type="checkbox" name="facility[]" class="service_tax1" id="' . $fc->facilityId . '">
                    <i class="fa ' . $fc->facility_icon . '"></i> ' . $fc->title . '</label> </div>   ';
            }
        }
    }
    ?>
</div>
<div class="col-md-4">
    <label><b>Requested Approved Facilities</b></label>
    <?php
    if (isset($orgFacilitiesa)) {
        foreach ($orgFacilitiesa as $ora) {
            if ($ora->mappingId) {
                echo '<div class="fac">
                    <label class="checkbox-inline">
                    <input checked value="' . $ora->facilityId . '" type="checkbox" name="facility[]" class="service_tax1" id="' . $ora->facilityId . '">
                    ' . $ora->title . '</label> </div>   ';
            } else {
                echo '<div class="fac">
                    <label class="checkbox-inline">
                    <input value="' . $ora->facilityId . '" type="checkbox" name="facility[]" class="service_tax1" id="' . $ora->facilityId . '">
                    <i class="fa ' . $ora->facility_icon . '"></i> ' . $ora->title . '</label> </div>   ';
            }
        }
    }
    ?>
</div>

<div class="col-md-4">
    <label><b>Requested Pending Facilities</b></label>
    <?php
    if (isset($orgFacilitiesp)) {
        foreach ($orgFacilitiesp as $ora) {
            if ($ora->mappingId) {
                echo '<div class="fac">
                                                            <label class="checkbox-inline">
                                                            <input checked value="' . $ora->facilityId . '" type="checkbox" name="facility[]" class="service_tax1" id="' . $ora->facilityId . '">
                                                            ' . $ora->title . '</label> </div>   ';
            } else {
                echo '<div class="fac">
                                                            <label class="checkbox-inline">
                                                            <input value="' . $ora->facilityId . '" type="checkbox" name="facility[]" class="service_tax1" id="' . $ora->facilityId . '">
                                                            <i class="fa ' . $ora->facility_icon . '"></i> ' . $ora->title . '</label> </div>   ';
            }
        }
    }
    ?>
</div>
<div class="clearfix"></div>