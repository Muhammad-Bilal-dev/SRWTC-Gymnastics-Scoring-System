<?php include 'protect.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Balance Beam Scoring</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Same styles as Vault/index.php */
    body {
      background-color: #ffffff;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .logo { height: 130px; display: block; margin: 15px auto; }
    .form-heading {
      text-align: center; color: #000; font-size: 2.1rem; font-weight: 800;
      margin-bottom: 25px; text-transform: uppercase; letter-spacing: 1px;
    }
    .scoring-table th {
      background-color: #ffcccc; color: #000; text-align: center;
      font-weight: 700; padding: 12px 8px;
    }
    .btn-red {
      background-color: #ff3131; border: 2px solid #ff3131; color: #fff;
      border-radius: 8px; font-weight: 700; padding: 10px 25px;
      font-size: 1.1rem; transition: all 0.3s;
    }
    .btn-red:hover {
      background-color: white !important; color: #ff3131 !important;
      border: 2px solid #ff3131;
    }
    .btn-outline {
      background-color: white; border: 2px solid #ff3131; color: #ff3131;
      font-weight: 700; padding: 8px 20px; transition: all 0.3s;
    }
    .btn-outline:hover {
      background-color: white !important; color: #ff3131 !important;
      border: 2px solid #ff3131;
    }
    footer {
      margin-top: 40px; padding: 25px; font-size: 0.9rem; color: #777;
      text-align: center; border-top: 1px solid #eee;
    }
    .support-info { font-size: 0.8rem; margin-top: 8px; color: #555; }
    .form-control:focus {
      border-color: #ff3131;
      box-shadow: 0 0 0 0.25rem rgba(255, 49, 49, 0.25);
    }
    .removeRow {
      background: #ff3131; color: white; border: none; border-radius: 5px;
      width: 32px; height: 32px; display: flex; align-items: center;
      justify-content: center; margin: 0 auto; transition: all 0.2s;
    }
    .removeRow:hover { background: #e82e2e; transform: scale(1.1); }
    .is-invalid {
      border-color: #dc3545;
      background-color: #fff8f8;
    }
    .error-message {
      color: #dc3545;
      font-size: 0.75rem;
      display: none;
    }
    @media (max-width: 768px) {
      .form-heading { font-size: 1.8rem; }
      .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }
      .container { padding: 0 15px; }
      .scoring-table th, .scoring-table td { padding: 8px 5px; }
      input.form-control-lg { padding: 0.5rem; font-size: 0.9rem; }
    }
    #addRow {
      background-color: #ff3131;
      color: white;
      border: 2px solid #ff3131;
      padding: 10px 25px;
      font-weight: 700;
      transition: all 0.3s;
    }
    #addRow:hover {
      background-color: white !important;
      color: #ff3131 !important;
      border: 2px solid #ff3131;
    }
  </style>
</head>
<body>

<img src="../logo.png" alt="SRWTC Logo" class="logo">
<h2 class="form-heading">Balance Beam Scoring</h2>

<div class="container mb-4" style="max-width: 1800px;">
  <form id="floorForm">
    <div class="table-responsive">
      <table class="table scoring-table table-bordered align-middle text-center" id="scoringTable">
        <thead>
          <tr>
            <th>Gymnast Number</th>
            <th>Difficulty</th>
            <th>Execution</th>
            <th>Bonus</th>
            <th>Neutral Deductions</th>
            <th>Final Score</th>
            <th>Remove</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <input type="number" step="1" name="gymnast_number" class="form-control form-control-lg" required>
              <div class="error-message">Must be a whole number</div>
            </td>
            <td><input type="number" step="0.01" name="d_score" class="form-control form-control-lg" required></td>
            <td><input type="number" step="0.01" name="e_score" class="form-control form-control-lg" required></td>
            <td><input type="number" step="0.01" name="bonus_score" class="form-control form-control-lg" value="0"></td>
            <td><input type="number" step="0.01" name="neutral_score" class="form-control form-control-lg" value="0"></td>
            <td><input type="number" step="0.01" name="final_score" class="form-control form-control-lg" readonly></td>
            <td><button type="button" class="btn removeRow">🗑</button></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="text-center mb-3 mt-4">
      <button type="button" class="btn me-3" id="addRow">➕ Add Row</button>
      <button type="button" class="btn btn-red px-5" data-bs-toggle="modal" data-bs-target="#confirmModal">
        SUBMIT SCORES
      </button>
    </div>
  </form>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
      <h5 class="modal-title text-center fw-bold mb-3">CONFIRM SUBMISSION</h5>
      <p class="mt-2 text-center">Are you sure all scores are correctly entered?</p>
      <div class="d-flex justify-content-center mt-4">
        <button type="button" class="btn btn-secondary me-3 px-4" data-bs-dismiss="modal">CANCEL</button>
        <button type="button" class="btn btn-red px-4" id="confirmSubmit">CONFIRM</button>
      </div>
    </div>
  </div>
</div>

<!-- Overwrite Confirmation Modal -->
<div class="modal fade" id="overwriteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
      <h5 class="modal-title text-center fw-bold mb-3">OVERWRITE SCORES?</h5>
      <p class="mt-2 text-center" id="overwriteMessage"></p>
      <div class="d-flex justify-content-center mt-4">
        <button type="button" class="btn btn-secondary me-3 px-4" data-bs-dismiss="modal">CANCEL</button>
        <button type="button" class="btn btn-red px-4" id="confirmOverwrite">OVERWRITE</button>
      </div>
    </div>
  </div>
</div>

<footer>
  <div class="fw-bold" style="color: #ff3131;">© SRWTC GYMNASTICS SCORING SYSTEM</div>
  <div class="support-info">
    Designed and maintained by Freddie Mullen<br>
    For support or enquiries, please contact:<br>
    E: support@srwtc.co.uk<br>
    M: 07796 184248<br>
    Interested in a similar system for your club or region? Contact Freddie
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const addRow = document.getElementById('addRow');
  const table = document.getElementById('scoringTable').querySelector('tbody');
  const scriptURL = 'submit-scores.php';
  let currentPayload = null;

  function calculateFinal(row) {
    const d = parseFloat(row.querySelector('[name="d_score"]').value) || 0;
    const e = parseFloat(row.querySelector('[name="e_score"]').value) || 0;
    const bonus = parseFloat(row.querySelector('[name="bonus_score"]').value) || 0;
    const neutral = parseFloat(row.querySelector('[name="neutral_score"]').value) || 0;
    const final = (10 + d - e + bonus - neutral).toFixed(2);
    row.querySelector('[name="final_score"]').value = final;
  }

  function attachListeners(row) {
    const inputs = row.querySelectorAll('input');
    inputs.forEach(input => {
      if (input.name !== 'final_score') {
        input.addEventListener('input', () => calculateFinal(row));
      }
    });

    row.querySelector('.removeRow').addEventListener('click', () => {
      if (table.rows.length > 1) row.remove();
    });
  }

  document.querySelectorAll('#scoringTable tbody tr').forEach(row => {
    calculateFinal(row);
    attachListeners(row);
  });

  addRow.addEventListener('click', () => {
    const row = table.rows[0].cloneNode(true);
    row.querySelectorAll('input').forEach(input => {
      if (input.name !== 'final_score') {
        input.value = input.name.includes('bonus') || input.name.includes('neutral') ? '0' : '';
      } else {
        input.value = '';
      }
      input.classList.remove('is-invalid');
    });
    row.querySelector('.error-message').style.display = 'none';
    table.appendChild(row);
    attachListeners(row);
    calculateFinal(row);
  });

  function validateForm() {
    const rows = Array.from(table.rows);
    let isValid = true;

    currentPayload = {
      sheet: "Balance Beam",
      scores: []
    };

    rows.forEach(row => {
      const gymnastInput = row.querySelector('[name="gymnast_number"]');
      const value = gymnastInput.value.trim();
      gymnastInput.classList.remove('is-invalid');
      const errorMsg = row.querySelector('.error-message');
      errorMsg.style.display = 'none';

      if (!value || !/^\d+$/.test(value) || value.includes('.') || isNaN(parseInt(value))) {
        isValid = false;
        gymnastInput.classList.add('is-invalid');
        errorMsg.style.display = 'block';
      }

      const dScore = row.querySelector('[name="d_score"]');
      const eScore = row.querySelector('[name="e_score"]');
      dScore.classList.remove('is-invalid');
      eScore.classList.remove('is-invalid');

      if (!dScore.value || isNaN(parseFloat(dScore.value))) {
        isValid = false;
        dScore.classList.add('is-invalid');
      }

      if (!eScore.value || isNaN(parseFloat(eScore.value))) {
        isValid = false;
        eScore.classList.add('is-invalid');
      }

      currentPayload.scores.push({
        gymnast_number: value,
        d_score: row.querySelector('[name="d_score"]').value,
        e_score: row.querySelector('[name="e_score"]').value,
        bonus_score: row.querySelector('[name="bonus_score"]').value,
        neutral_score: row.querySelector('[name="neutral_score"]').value,
        final_score: row.querySelector('[name="final_score"]').value
      });
    });

    return isValid;
  }

  function submitScores(payload) {
    const submitBtn = document.getElementById('confirmSubmit');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Submitting...';

    fetch(scriptURL, {
      method: 'POST',
      body: JSON.stringify(payload),
      headers: {
        'Content-Type': 'application/json'
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.status === "success") {
        window.location.href = "success.php";
      } else if (data.status === "invalid_gymnast") {
        // Mark invalid gymnast numbers in the form
        data.invalid_numbers.forEach(num => {
          Array.from(table.rows).forEach(row => {
            const gymnastInput = row.querySelector('[name="gymnast_number"]');
            if (gymnastInput.value === String(num)) {
              gymnastInput.classList.add('is-invalid');
              const errorMsg = row.querySelector('.error-message');
              errorMsg.style.display = 'block';
            }
          });
        });
        alert(`Invalid gymnast number(s): ${data.invalid_numbers.join(', ')}`);
        submitBtn.disabled = false;
        submitBtn.innerHTML = "CONFIRM";
      } else if (data.status === "overwrite_warning") {
        // Hide original modal
        const confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmModal'));
        confirmModal.hide();
        
        // Show overwrite modal
        const overwriteModal = new bootstrap.Modal(document.getElementById('overwriteModal'));
        document.getElementById('overwriteMessage').innerText = 
          `Scores for gymnast #${data.existing_gymnasts.join(', #')} are already inputted. Do you want to overwrite?`;
        overwriteModal.show();
      } else {
        throw new Error(data.message || "Unknown error occurred");
      }
    })
    .catch(error => {
      alert('Error: ' + error.message);
      submitBtn.disabled = false;
      submitBtn.innerHTML = "CONFIRM";
    });
  }

  document.getElementById('confirmSubmit').addEventListener('click', () => {
    if (!validateForm()) {
      alert("Please correct invalid entries before submitting.");
      return;
    }
    
    submitScores(currentPayload);
  });

  document.getElementById('confirmOverwrite').addEventListener('click', () => {
    if (currentPayload) {
      currentPayload.forceOverwrite = true;
      const overwriteBtn = document.getElementById('confirmOverwrite');
      overwriteBtn.disabled = true;
      overwriteBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Overwriting...';
      
      fetch(scriptURL, {
        method: 'POST',
        body: JSON.stringify(currentPayload),
        headers: { 'Content-Type': 'application/json' }
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === "success") {
          window.location.href = "success.php";
        } else {
          throw new Error(data.message || "Unknown error occurred");
        }
      })
      .catch(error => {
        alert('Error: ' + error.message);
        overwriteBtn.disabled = false;
        overwriteBtn.innerHTML = "OVERWRITE";
      });
    }
  });

  // Reset modals when closed
  document.getElementById('overwriteModal').addEventListener('hidden.bs.modal', function() {
    const overwriteBtn = document.getElementById('confirmOverwrite');
    overwriteBtn.disabled = false;
    overwriteBtn.innerHTML = 'OVERWRITE';
  });
  
  document.getElementById('confirmModal').addEventListener('hidden.bs.modal', function() {
    const submitBtn = document.getElementById('confirmSubmit');
    submitBtn.disabled = false;
    submitBtn.innerHTML = "CONFIRM";
  });
</script>
</body>
</html>