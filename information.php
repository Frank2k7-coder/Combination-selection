<?php
session_start();

if (!isset($_SESSION['user_id'], $_SESSION['combination'])) {
    die("Access denied.");
}
$comb = $_SESSION['combination'];
?>
<!DOCTYPE html>
<html>
<head>
  <title>Enter Your Marks</title>
  <style>
    body { font-family: Arial; 
          background: #f4f4f4; 
          display: flex; 
          justify-content:center; 
          align-items:center; 
          height:100vh; }
    .marks-container { 
      background:#fff; 
      padding:30px; 
      border-radius:10px; 
      box-shadow:0 0 10px rgba(0,0,0,.2); 
      width:400px; text-align:center; }
    input[type="number"] { 
      width:80%;
                         
      padding:10px; 
      margin:15px 0; 
      border-radius:5px; 
      border:1px solid #ccc;
      font-size:18px; 
      text-align:center; }

    button { 
      background:orange; 
      color:#fff;
      border:none; 
      padding:10px 20px; 
      border-radius:5px; 
      font-size:16px; 
      cursor:pointer; }
    button:hover { b
      ackground:darkorange; }
    .subject-name {
      
      font-size:22px; 
      font-weight:bold; 
    }
  </style>
</head>
<body>
  <div class="marks-container">
    <h2>Enter Your Marks</h2>
    <form id="marksForm" action="data.php" method="post">
      <div class="subject-name" id="subjectLabel"></div>
      <input type="number" name="marks[]" id="marksInput" placeholder="0–100" min="0" max="100" required>
      <input type="hidden" name="subjects[]" id="subjectInput">
      <br>
      <button type="button" id="nextBtn">Next</button>
    </form>
  </div>

  <script>
    const comb = "<?php echo $comb; ?>";
    const combos = {
      "MPC":["Mathematics","Physics","Computer Science"],
      "MCE":["Mathematics","Economics","Computer Science"],
      "MEG":["Mathematics","Economics","Geography"],
      "PCB":["Physics","Chemistry","Biology"],
      "HGL":["History","Geography","Literature"]
    };
    const extras = ["GP","Kinyarwanda","English","ENT"];
    const subjects = (combos[comb]||[]).concat(extras);
    let idx = 0;
    const lbl=document.getElementById("subjectLabel"),
          inp=document.getElementById("marksInput"),
          hid=document.getElementById("subjectInput"),
          btn=document.getElementById("nextBtn"),
          form=document.getElementById("marksForm");

    function load(i){
      lbl.textContent = subjects[i];
      hid.value = subjects[i];
      inp.value = "";
      btn.textContent = i===subjects.length-1 ? "Submit" : "Next";
      inp.focus();
    }

    btn.addEventListener("click", ()=>{
      let v=inp.value.trim();
      if(v===""||v<0||v>100) return alert("Enter 0–100");
    
      let s=document.createElement("input"), m=s.cloneNode();
      s.type=m.type="hidden"; s.name="subjects[]"; m.name="marks[]";
      s.value=subjects[idx]; m.value=v;
      form.appendChild(s); form.appendChild(m);

      idx++;
      if(idx<subjects.length) load(idx);
      else form.submit();
    });

    load(0);
  </script>
</body>
</html>
