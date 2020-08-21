<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title) ? $title : null) ?></h2>
                </div>
            </div>
            <div class="panel-body">
                <table class="datatable2 table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th><?php echo display('sl_no') ?></th>
                            <th><?php echo "Pin Code" ?></th>
                            <th><?php echo "Pin Amount" ?></th>
                            <th><?php echo "Used" ?></th>
                            <th><?php echo "Date Used" ?></th>
                            <th><?php echo "Date Created" ?></th>
                            <th><?php echo "Created By" ?></th>
                            <th><?php echo display('action') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pin)) ?>
                        <?php $sl = 1; ?>
                        <?php foreach ($pin as $value) { ?>
                            <tr>
                                <td><?php echo $sl++; ?></td>
                                <td><?php echo $value->pin_code; ?></td>
                                <td><?php echo $value->pin_amount; ?></td>
                                <td><?php echo $value->is_used ? '<div class="label label-success">True</div>' : '<div class="label label-danger">False</div>'; ?></td>
                                <td><?php echo $value->date_used; ?></td>
                                <td><?php echo $value->created; ?></td>
                                <td><?php echo $value->created; ?></td>
                                <td>
                                    <a href="<?php echo base_url("backend/pin/pin/form/$value->pin_id") ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Update"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <a href="<?php echo base_url("backend/pin/pin/delete/$value->pin_id") ?>" onclick="return confirm('<?php echo display("are_you_sure") ?>')" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" title="Delete "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php echo $links; ?>
            </div>
        </div>
    </div>
</div>