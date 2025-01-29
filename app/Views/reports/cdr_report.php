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
    <h2 class="my-4 text-center text-dark">CDR Report</h2>
    <form method="get" action="<?= base_url('/reports/cdr'); ?>">
        <input type="hidden" name="flag" id="flag" value="MySQL">
        <button type="submit" onclick="setFlag('MySQL')" class="btn btn-secondary">MySQL CDR Report</button>
        <button type="submit" onclick="setFlag('MongoDB')" class="btn btn-secondary">MongoDB CDR Report</button>
        <button type="submit" onclick="setFlag('Elastic')" class="btn btn-secondary">Elasticsearch CDR Report</button>
    </form>

    <div class="d-flex">
        <a href="<?= site_url('/reports/cdr/download?flag=' . $flag) ?>" class="btn btn-primary mb-3">Download CDR Report</a>
        <!-- Filter Modal -->
        <a href="" class="btn btn-primary mb-3 ms-3" data-bs-toggle="modal" data-bs-target="#filterModal">Filter</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered text-center">
            <thead class="thead-dark">
                <tr>
                    <th>Agent Name</th>
                    <th>Campaign Name</th>
                    <th>Process Name</th>
                    <th>Initiated Time</th>
                    <th>Report Type</th>
                    <th>Dispose Type</th>
                    <th>Dispose Name</th>
                    <th>Leadset</th>
                    <th>Reference UUID</th>
                    <th>Customer UUID</th>
                    <th>Hold</th>
                    <th>Mute</th>
                    <th>Ringing</th>
                    <th>TX Time</th>
                    <th>Conference</th>
                    <th>Talk Time</th>
                    <th>Dispose Time</th>
                    <th>Duration</th>
                </tr>
            </thead>
            <tbody>
                <?php $num = 1; ?>
                <?php foreach ($cdrData as $row): ?>
                    <tr>
                        <td><?= $row['agentName'] ?></td>
                        <td><?= $row['campaignName'] ?></td>
                        <td><?= $row['processName'] ?></td>
                        <td><?= $row['initiatedTime'] ?></td>
                        <td><?= $row['reportType'] ?></td>
                        <td><?= $row['disposeType'] ?></td>
                        <td><?= $row['disposeName'] ?></td>
                        <td><?= $row['leadset'] ?></td>
                        <td><?= $row['referenceUuid'] ?></td>
                        <td><?= $row['custumerUuid'] ?></td>
                        <td><?= gmdate("H:i:s", $row['hold']) ?></td>
                        <td><?= gmdate("H:i:s", $row['mute']) ?></td>
                        <td><?= gmdate("H:i:s", $row['ringing']) ?></td>
                        <td><?= gmdate("H:i:s", $row['txTime']) ?></td>
                        <td><?= gmdate("H:i:s", $row['conference']) ?></td>
                        <td><?= gmdate("H:i:s", $row['talktime']) ?></td>
                        <td><?= $row['disposeTime'] ?></td>
                        <td><?= gmdate("H:i:s", $row['duration']) ?></td>
                    </tr>
                    <?php $num++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- CodeIgniter Pagination Links -->
    <div class="d-flex justify-content-center">
        <?= $pager ?>
    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter Options</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="filterForm" method="getVar" action="/reports/cdr/filter">
                    <div class="mb-3">
                        <label for="databaseOptions" class="form-label">Select Database:</label>
                        <select class="form-select" id="databaseOptions" name="databaseOptions">
                            <option value="mysql">MySQL</option>
                            <option value="mongo">MongoDB</option>
                            <option value="elastic">Elasticsearch</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="typeOptions" class="form-label">Select Type:</label>
                        <select class="form-select" id="typeOptions" name="typeOptions">
                            <option value="agentName">By Agent Name</option>
                            <option value="campaignName">By Campaign Name</option>
                            <option value="processName">By Process Name</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="filterName" class="form-label">Filter by Name</label>
                        <input type="text" class="form-control" id="filterName" name="filterName" placeholder="Enter name" style="width: 100%;">
                    </div>

                    <div class="mb-3">
                        <label for="disposeTypeOptions" class="form-label">Select Dispose Type:</label>
                        <select class="form-select" id="disposeTypeOptions" name="disposeTypeOptions">
                            <option value="" disabled selected>Select Dispose Type</option>
                            <option value="Callback">Callback</option>
                            <option value="DNC">DNC</option>
                            <option value="ETX">ETX</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function setFlag(value) {
        document.getElementById('flag').value = value;
        document.forms[0].submit();
    }
</script>

<?= $this->include('layouts/footer') ?>