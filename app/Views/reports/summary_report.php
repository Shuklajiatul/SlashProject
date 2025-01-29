<style>
    .pagination {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .pagination a {
        border: 1px solid #ddd;
        padding: 8px 16px;
        margin: 0 5px;
        text-decoration: none;
        color: #007bff;
        background-color: #f8f9fa;
    }

    .pagination a:hover {
        background-color: #ddd;
    }

    .pagination .active a {
        background-color: #007bff;
        color: white;
        border: 1px solid #007bff;
    }
</style>
<?= $this->include('layouts/header') ?>

<div class="container mt-4">
    <h2 class="my-4 text-center text-dark">Summary Report</h2>
    <form method="get" action="<?php echo base_url('/reports/summary'); ?>">
        <input type="hidden" name="flag" id="flag" value="MySQL"> 
        <button type="submit" onclick="setFlag('MySQL')" class="btn btn-secondary">MySQL Summary Report</button>
        <button type="submit" onclick="setFlag('MongoDB')" class="btn btn-secondary">MongoDB Summary Report</button>
        <button type="submit" onclick="setFlag('Elastic')" class="btn btn-secondary">Elasticsearch Summary Report</button>
    </form>
    
    <a href="<?= site_url('/reports/summary/download?flag=').$flag ?>" class="btn btn-primary mb-3">Download Summary Report</a>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered text-center">
            <thead class="thead-dark">
                <tr>
                    <th>Date & Time</th>
                    <th>Agent Name</th>
                    <th>Campaign Name</th>
                    <th>Process Name</th>
                    <th>Dispose Type</th>
                    <th>Total Ringing Time</th>
                    <th>Total Hold Time</th>
                    <th>Total Talk Time</th>
                    <th>Total Mute Time</th>
                    <th>Total Transfer Time</th>
                    <th>Total Conference Time</th>
                    <th>Total Duration</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($summary as $row): ?>
                    <tr>
                        <td>
                            <?php 
                            if (isset($row['_id'])) {
                                $timestamp = sprintf('%04d-%02d-%02d %02d:00:00', 
                                    $row['_id']['year'], 
                                    $row['_id']['month'], 
                                    $row['_id']['day'], 
                                    $row['_id']['hour']
                                );
                                echo $timestamp;
                            } else {
                                echo $row['hour'];
                            }
                            ?>
                        </td>
                        <td><?= $row['agentName'] ?></td>
                        <td><?= $row['campaignName'] ?></td>
                        <td><?= $row['processName'] ?></td>
                        <td><?= $row['disposeType'] ?></td>
                        <td><?= $row['totalRingingTime'] ?></td>
                        <td><?= $row['totalHoldTime'] ?></td>
                        <td><?= $row['totalTalkTime']?></td>
                        <td><?= $row['totalMuteTime'] ?></td>
                        <td><?= $row['totalTransferTime'] ?></td>
                        <td><?= $row['totalConferenceTime'] ?></td>
                        <td><?= $row['totalDuration'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        <?= $pager ?>
    </div>
</div>

<script>
    function setFlag(value) {
        document.getElementById('flag').value = value;
        document.forms[0].submit();
    }
</script>

<?= $this->include('layouts/footer') ?>
