
import { baseUrl } from "../config.js";

export default class kategori{

    constructor(cek){
        if(cek ==="nonproses"){
            this.renderedit()
        }else{
            this.render();
        }
       
    }

   renderedit() {
    const transnoHider = $("#transnoHider").val();
    $.ajax({
        url: `${baseUrl}/router/seturl`,
        method: "POST",
        data: { "transnoHider": transnoHider },
        dataType: "json",
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        headers: { 'url': 'mskat/listkategoribyid' },

        success: (result) => {
            this.setKategori(result, true); // isEdit = true
        },
        error: function () {
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: "Terjadi kesalahan saat menampilkan data."
            });
        }
    });
}

render() {
    $.ajax({
        url: `${baseUrl}/router/seturl`,
        method: "GET",
        dataType: "json",
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        headers: { 'url': 'mskat/listkategori' },

        success: (result) => {
            this.setKategori(result, false); // isEdit = false
        },
        error: function () {
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: "Terjadi kesalahan saat menampilkan data."
            });
        }
    });
}


 setKategori(result, isEdit = false) {
    const listId = document.getElementById("listkategori");
    let html = '';

    result.forEach(element => {
        const ktg = element.kategori;
        const id = element.IDKategori;
        let totalHTML = '';

        if (isEdit && element.TotalAmount !== undefined) {
            const total = element.TotalAmount ?? 0;
            totalHTML = total.toLocaleString('id-ID');

        }

        html += `
            <div class="row mb-2">
                <label for="total_kategori${id.replace(/\./g, '')}" style="width: 20%;" class="col-form-label">
                    Kategori ${ktg}
                </label>
                <div style="width: 35%;" class="col-sm-6">
                    <span id="total_kategori${id.replace(/\./g, '')}" style="display: flex; justify-content: flex-end;">
                        ${totalHTML}
                    </span>
                </div>
            </div>`;
    });

    listId.innerHTML = html;
}

}