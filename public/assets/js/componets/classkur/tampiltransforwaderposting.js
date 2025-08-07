import { baseUrl } from "../config.js";

export default class TransakiForwoder_Posting{
        constructor(containerSelector) {
            this.container = document.querySelector(containerSelector);
            this.getDataForwarder();
        
        }


    getDataForwarder(){
        const transnoHider =$("#transnoHider").val();
        $.ajax({
            url: `${baseUrl}/router/seturl`,
            method: "POST",
            dataType: "json",
            data:{"transnoHider":transnoHider},
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            headers: { 'url': 'msfor/tampilforwaderedit' },

            success:(result)=>{
                this.setModalData(result);
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: "Terjadi kesalahan saat menampilkan data."
                });
            }
        });
    };

  setModalData(result) {
        const header = result.header;
    const detail = result.detaildata
    const total_hitung = this.settotalamountHitungan(header);
    const total_rumus = this.settotalamountRumus(header)
    const modal = document.createElement("div");
    modal.className = "modal fade";
    modal.id = "modaltransforwaderposting";
    modal.tabIndex = -1;
    modal.setAttribute("data-bs-backdrop", "static");
    modal.setAttribute("data-bs-keyboard", "false");
    modal.setAttribute("aria-labelledby", "modaltransforwaderpostingLabel");
    modal.setAttribute("aria-hidden", "true");
    modal.innerHTML  = `
        <!-- Modal -->
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTableeditLabel">Detail Forwader Edit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                        <table class="table table-striped table-hover" id="table_DetailforwaderEdit">
                            <thead>
                                  <tr>
                                    <th class="col-md-1 text-center">No</th>
                                    <th class="col-md-2 text-start">Kategori</th>
                                    <th class="col-md-4 text-end">Amonut</th>
                                    <th class="col-md-4 text-start" >Keterangan</th>
                                    <th class="col-md-4 text-center">Hitungan</th>
                                    <th class="col-md-4 text-center">Rumus</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                ${this.generateTableRows(header)}
                            </tbody>
                            <tfoot>
                            <tr>
                            <td colspan="4" class="text-end fw-bold">Total:</td>
                            <td class="text-center fw-bold" id="totalAmounthitungan">${total_hitung}</td>
                            <td class="text-center fw-bold" id="totalAmountrumus">${total_rumus}</td>
                            </tr>
                             <tr>
                             ${this.setIdTotalKategori(header)}
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>`;
    this.container.appendChild(modal);
   
     const modalInstance = new bootstrap.Modal(document.getElementById('modaltransforwaderposting'));
    modalInstance.show();
    this.setTotaledit(detail);
 

 
};
    setTotaledit(detail){
        detail.forEach(element=>{
            const ktg = element.kategori;
        if (element.TotalAmount !== undefined) {
            const total = element.TotalAmount ?? 0;
            let totalHTML = total.toLocaleString('id-ID');
           
            let idedit = `#total_${ktg}`;
            let total_edit  = ktg+" : "+totalHTML;
            $(idedit).text(total_edit);
        }
        })
    }

    setTotaledit(detail){
        detail.forEach(element=>{
            const ktg = element.kategori;
               const idktg = element.IDKategori.replace(/\./g, '');
        if (element.TotalAmount !== undefined) {
            const total = element.TotalAmount ?? 0;
            let totalHTML = total.toLocaleString('id-ID');
           
            let idedit = `#total_${idktg}`;
            let total_edit  = ktg+" : "+totalHTML;
            $(idedit).text(total_edit);
        }
        })
    }
 setIdTotalKategori(result){
        const uniquerKategori  = Object.values(
            result.reduce((acc,item)=>{
            acc[item.IDKategori] ??= { IDKategori: item.IDKategori, kategori: item.kategori };
                return acc;
            },{})
        )


        const map = new Map();
        uniquerKategori.forEach(item => {
            if (!map.has(item.IDKategori)) {
            map.set(item.IDKategori, item.kategori);
            }
        });
 let tdHTML =`<td></td>`;
   
        tdHTML += [...map.entries()].map(
            ([id, kat]) => `<td  id="total_${id.replace(/\./g,'')}"
            class="text-start fw-bold"></td>`
        ).join('');


     //TransaksiHelper.setamountkeup(str_idctns);
        return `<tr>${tdHTML}</tr>`;
    
    }
 generateTableRows(data){
    if (!Array.isArray(data)) return `<tr><td colspan="5">Tidak ada data</td></tr>`;
    
    let hasil =``;
    let groupamount =``;
    $.each(data,function(index,item){

        let idmount =`amount${index+1}`;
        groupamount+=idmount+',';
       hasil +=  `
        <tr>
            <td class="col-md-1 text-center">${index + 1}</td>
             <td class="col-md-2 text-start" id="${item.IDKategori}">${item.kategori || ''}</td>
            <td class="col-md-4 text-end" ><input disabled value="${item.amount}" style="width:50% text-align: right;" type"text" name="amount" class="amount form-control text-end" id="${idmount}"></td>
            <td class="col-md-4 text-start" id="${item.msID}">${item.keterangan || ''}</td>
            <td class="col-md-4 text-center hitungan " id="${item.hitungan}">${item.hitungan}</td>
            <td  class="col-md-4 text-center rumus" id="${item.rumus}">${item.rumus}</td>
        </tr>`;
    })
    let str_idctns = groupamount.slice(0,-1);
     TransaksiHelper.setamountkeup(str_idctns);
    return hasil;
};


settotalamountHitungan(result){
    if (!Array.isArray(result)) return ``;
    let total ="";
    result.forEach(element => {
        total =element.total_hitungan
    });
    return total;
}
 settotalamountRumus(result){
if (!Array.isArray(result)) return ``;
    let total ="";
    result.forEach(element => {
        total =element.total_rumus
    });
    return total;
}




}

const TransaksiHelper = {
    setamountkeup(datasID) {
        const self = this;

        let idsplit = datasID.split(",");

        $.each(idsplit, function(index1, value1) {
            let id_amount = "#" + value1;
            $(document).on('keyup', id_amount, function() {
                let inputid_amount = $(this).val();
                let formattedVal1 = self.Rupiah(inputid_amount);
                $(this).val(formattedVal1);
            });
        });
    },

    Rupiah(angka, prefix) {
        let number_string = angka.replace(/[^0-9.]/g, '').toString();
        let split = number_string.split('.');
        
        if (split[1]) {
            split[1] = split[1].substring(0, 2);
        }

        let sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        let ribuan = split[0].substr(sisa).match(/\d{3}/gi);
        let separator = '';

        if (ribuan) {
            separator = sisa ? ',' : '';
            rupiah += separator + ribuan.join(',');
        }

        rupiah = split[1] != undefined ? rupiah + '.' + split[1] : rupiah;

        return prefix == undefined ? rupiah : (rupiah ? prefix + rupiah : '');
    }

};


