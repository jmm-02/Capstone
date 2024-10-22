function populateSecondDropdown() {
      var firstDropdown = document.getElementById("first-dropdown");
      var secondDropdown = document.getElementById("second-dropdown");
      var selectedOption = firstDropdown.value;
      
      secondDropdown.innerHTML = "";
      
      if (selectedOption === "Alaminos") {
        var barangays = ["Alos", "Palamis", "Amandiego", "Pandan", "Amangbangan", "Pangapisan", "Balangobong", "Poblacion(Alaminos)", "Balayang", "Pocal-pocal", "Baleyadaan", "Pogo", "Bisocol", "Polo", "Bolaney", "Quibuar", "Bued", "Sabangan", "Cabatuan", "San Antonio", "Cayucay", "San Jose", "Dulacac", "San Roque", "Inerangan", "San Vicente", "Landoc", "Sta Maria", "Linmansangan", "Tanaytay", "Lucap", "Tangcarang", "Maawi", "Tawin-tawin", "Macatiw", "Telbang", "Magsaysay", "Victoria", "Mona"];
        
        for (var i = 0; i < barangays.length; i++) {
          var option = document.createElement("option");
          option.text = barangays[i];
          option.value = barangays[i];
          secondDropdown.add(option);
        }

      } else if (selectedOption === "Bay") {
        var barangays = ["Bitin", "Calo", "Dila", "Maitim", "Masaya", "Paciano Rizal", "Puypuy", "San Antonio", "San Isidro(Bay)", "Santa Cruz", "Santo Domingo", "Tagumpay", "Tranca", "San Agustin (Poblacion)", "San Nicolas (Poblacion)"];
        
        for (var i = 0; i < barangays.length; i++) {
          var option = document.createElement("option");
          option.text = barangays[i];
          option.value = barangays[i];
          secondDropdown.add(option);
        }
      } else if (selectedOption === "Binan") {
        var barangays = ["Biñan", "Bungahan", "Santo Tomas (Calabuso)", "Canlalay", "Casile", "De La Paz", "Ganado", "San Francisco (Halang)", "Langkiwa", "Loma", "Malaban", "Malamig", "Mampalasan (Mamplasan)", "Platero", "Poblacion(Biñan)", "Santo Niño", "San Antonio", "San Jose", "San Vicente", "Soro-soro", "Santo Domingo", "Timbao", "Tubigan", "Zapote"];
        
        for (var i = 0; i < barangays.length; i++) {
          var option = document.createElement("option");
          option.text = barangays[i];
          option.value = barangays[i];
          secondDropdown.add(option);
        }
      } else if (selectedOption === "Cabuyao") {
        var barangays = ["Baclaran", "Banaybanay", "Banlic", "Bigaa", "Butong", "Casile", "Diezmo", "Gulod", "Mamatid", "Marinig", "Niugan", "Pittland", "Poblacion Uno", "Poblacion Dos", "Poblacion Tres", "Pulo", "Sala", "San Isidro(Cabuyao)"];
        
        for (var i = 0; i < barangays.length; i++) {
          var option = document.createElement("option");
          option.text = barangays[i];
          option.value = barangays[i];
          secondDropdown.add(option);
        }
      } else if (selectedOption === "Calauan") {
        var barangays = ["Balayhangin", "Bangyas", "Dayap", "Hanggan", "Imok", "Lamot 1", "Lamot 2", "Limao", "Mabacan", "Masiit", "Paliparan", "Pérez", "Kanluran (Poblacion)", "Silangan (Poblacion)", "Prinza", "San Isidro(Calauan)", "Santo Tomas"];
        
        for (var i = 0; i < barangays.length; i++) {
          var option = document.createElement("option");
          option.text = barangays[i];
          option.value = barangays[i];
          secondDropdown.add(option);
        }
      } else if (selectedOption === "Calamba") {
        var barangays = ["Bagong Kalsada", "Banadero", "Banlic", "Barandal", "Barangay 1 (Poblacion 1)", "Barangay 2 (Poblacion 2)", "Barangay 3 (Poblacion 3)", "Barangay 4 (Poblacion 4)", "Barangay 5 (Poblacion 5)", "Barangay 6 (Poblacion 6)", "Barangay 7 (Poblacion 7)", "Batino", "Bubuyan", "Bucal", "Bunggo", "Burol", "Camaligan", "Canlubang", "Halang", "Hornalan", "Kay-Anlog", "Laguerta", "La Mesa", "Lawa", "Lecheria", "Lingga", "Looc", "Mabato", "Majada Labas", "Makiling", "Mapagong", "Masili", "Maunong", "Mayapa", "Milagrosa (Tulo)", "Paciano Rizal", "Palingon", "Palo-Alto", "Pansol", "Parian", "Prinza", "Punta", "Puting Lupa", "Real", "Saimsim", "Sampiruhan", "San Cristobal", "San Jose", "San Juan", "Sirang Lupa", "Sucol", "Turbina", "Ulango", "Uwisan"];
        
        for (var i = 0; i < barangays.length; i++) {
          var option = document.createElement("option");
          option.text = barangays[i];
          option.value = barangays[i];
          secondDropdown.add(option);
        }
      } else if (selectedOption === "Los Baños") {
        var barangays = ["Anos", "Bagong Silang", "Bambang", "Batong Malake", "Baybayin", "Bayog", "Lalakay", "Maahas", "Malinta", "Mayondon", "Putho-Tuntungin", "San Antonio", "Tadlac", "Timugan"];
        
        for (var i = 0; i < barangays.length; i++) {
          var option = document.createElement("option");
          option.text = barangays[i];
          option.value = barangays[i];
          secondDropdown.add(option);
        }
      } else if (selectedOption === "San Pablo") {
        var barangays = ["I-A (Sambat)", "I-B (City+Riverside)", "I-C (Bagong Bayan)", "II-A (Triangulo)", "II-B (Guadalupe)", "II-C (Unson)", "II-D (Bulante)", "II-E (San Anton)", "II-F (Villa Rey)", "III-A (Hermanos Belen)", "III-B", "III-C (Labak/De Roma)", "III-D (Villongco)", "III-E", "III-F (Balagtas)", "IV-A", "IV-B", "IV-C", "V-A", "V-B", "V-C", "V-D", "VI-A (Mavenida)", "VI-B", "VI-C (Bagong Pook)", "VI-D (Lparkers)", "VI-E (YMCA)", "VII-A (P.Alcantara)", "VII-B", "VII-C", "VII-D", "VII-E", "Atisan", "Bautista", "Concepcion (Bunot)", "Del Remedio (Wawa)", "Dolores", "San Antonio 1 (Balanga)", "San Antonio 2 (Sapa)", "San Bartolome (Matang-ag)", "San Buenaventura (Palakpakin)", "San Crispin (Lumbangan)", "San Cristobal", "San Diego (Tiim)", "San Francisco (Calihan)", "San Gabriel (Butucan)", "San Gregorio", "San Ignacio", "San Isidro (Balagbag)", "San Joaquin", "San Jose (Malamig)", "San Juan", "San Lorenzo (Saluyan)", "San Lucas 1 (Malinaw)", "San Lucas 2", "San Marcos (Tikew)", "San Mateo", "San Miguel", "San Nicolas", "San Pedro", "San Rafael (Magampon)", "San Roque (Buluburan)", "San Vicente", "Santa Ana", "Santa Catalina (Sandig)", "Santa Cruz (Putol)", "Santa Elena", "Santa Filomena (Banlagin)", "Santa Isabel", "Santa Maria", "Santa Maria Magdalena (Boe)", "Santa Monica", "Santa Veronica (Bae)", "Santiago I (Bulaho)", "Santiago II", "Santisimo Rosario", "Santo Angel (Ilog)", "Santo Cristo", "Santo Niño (Arsum)", "Soledad (Macopa)"];
        
        for (var i = 0; i < barangays.length; i++) {
          var option = document.createElement("option");
          option.text = barangays[i];
          option.value = barangays[i];
          secondDropdown.add(option);
        }
      } else if (selectedOption === "San Pedro") {
        var barangays = ["Bagong Silang", "Calendola", "Chrysanthemum[a]", "Cuyab", "Estrella", "Fatima[a]", "G.S.I.S.", "Landayan", "Langgam", "Laram", "Maharlika[a]", "Magsaysay", "Narra", "Nueva", "Pacita 1[a]", "Pacita 2[a]", "Poblacion(San Pedro)", "Riverside", "Rosario[a]", "Sampaguita Village", "San Antonio", "San Roque", "San Vicente", "San Lorenzo Ruiz[a]", "Santo Niño", "United Bayanihan", "United Better Living"];
        
        for (var i = 0; i < barangays.length; i++) {
          var option = document.createElement("option");
          option.text = barangays[i];
          option.value = barangays[i];
          secondDropdown.add(option);
        }
      } else if (selectedOption === "Sta Rosa") {
        var barangays = ["Aplaya", "Balibago", "Caingin", "Dila", "Dita", "Don Jose", "Ibaba", "Kanluran (Poblacion Uno)", "Labas", "Macabling", "Malitlit", "Malusak (Poblacion Dos)", "Market Area (Poblacion Tres)", "Pooc (Pook)", "Pulong Santa Cruz", "Santo Domingo", "Sinalhan", "Tagapo"];
        
        for (var i = 0; i < barangays.length; i++) {
          var option = document.createElement("option");
          option.text = barangays[i];
          option.value = barangays[i];
          secondDropdown.add(option);
        }
      }
    }

