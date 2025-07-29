const readline = require('readline');

function formatRupiah2(value) {
  if (!value) return '';

  //value = value.replace(',', '.');

  value = value.replace(/[^0-9.]/g, '');
  console.log(value)

  const parts = value.split('.');
  if (parts.length > 2) {
    value = parts[0] + '.' + parts[1];
  }

  const number = parseFloat(value);
  if (!isNaN(number)) {
    return number.toLocaleString('en-US', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });
  }

  return '';
}

// Setup readline untuk input dari terminal
const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

rl.question('Masukkan angka: ', function(input) {
  const formatted = formatRupiah2(input);
  console.log('Hasil format:', formatted);
  rl.close();
});
