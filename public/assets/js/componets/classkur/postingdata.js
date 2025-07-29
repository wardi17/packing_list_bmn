// config.js tetap pakai yang sama
import { baseUrl } from "../config.js";
import{goBack} from "./index.js";
class KurDataService {
    constructor() {
        this.baseUrl = baseUrl;
    }



    postingData(datas) {
        $.ajax({
            url: `${this.baseUrl}/router/seturl`,
            method: "POST",
            dataType: "json",
            data:JSON.stringify(datas),
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            headers: { url: 'transkur/postingdata' },
            beforeSend: function () {
                Swal.fire({
                    title: 'Loading',
                    html: 'Please wait...',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function (result) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1000,
                    text: result.error,
                }).then(function () {
                    goBack();
                });
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: "Terjadi kesalahan saat Posting data."
                });
            }
        });
    }

    PostingdataKur() {
       
       const transnoHider  = $("#transnoHider").val();
        const fullData = {
            transnoHider: transnoHider,
        };
 
        
        this.postingData(fullData);
    }
}

// Cara pemakaian:

export function PostingdataKur() {
    const kurService = new KurDataService();
    kurService.PostingdataKur();
}
