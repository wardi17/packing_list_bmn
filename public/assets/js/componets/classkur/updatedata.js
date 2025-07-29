// config.js tetap pakai yang sama
import { baseUrl } from "../config.js";
import{goBack} from "./index.js";
class KurDataService {
    constructor() {
        this.baseUrl = baseUrl;
    }

    getFormData() {
       const pib           = $("#pib").val();
        const forwarder     = $("#forwarder").val();
        const transnoHider  = $("#transnoHider").val();
        const suplieid      = $("#suplair").find(":selected").val();
        const nopo          = $("#nopo").find(":selected").val();
        const nodo          = $("#nopo").find(":selected").text();
        const tanggal       = $("#tanggal").val();
        const ket           = $("#keterangan").val();
        const idpackinglist = $("#idpackinglist").val();
        const id_bl_awb     = $("#id_bl_awb").val();
        const total         = $("#total").text();
        const total_usd     = $("#total_usd").text();
        const total_rp      = $("#total_rp").text();
        const total_amountakhir = $("#total_amountakhir").text();
        const total_Prosentase        =$("#total_Prosentase").text();

        let dataheader ={
          "transo"        :transnoHider,
          "suplieid"      :suplieid,
          "nodo"          :nodo,
          "nopo"          :nopo,
          "tanggal"       :tanggal,
          "keterangan"    :ket,
          "idpackinglist" :idpackinglist,
          "pib"           :0,
          "forwarder"     :forwarder.replace(/\,/g,""),
          "id_bl_awb"     :id_bl_awb,
          "total"         :0,
          "total_usd"     :total_usd.replace(/\,/g,"").trim(),
          "total_rp"      :total_rp.replace(/\,/g,"").trim(),
          "total_amountakhir" :total_amountakhir.replace(/\,/g,"").trim(),
          "total_Prosentase"  :total_Prosentase.replace(/\,/g,"").trim(),
          
        };
        return dataheader;
    }


   ambilDataTabelForwader(selector){
        const data = [];

        $(selector).each(function () {
            const msID = $(this).find('td:eq(2)').attr("id");
            const hitungan = $(this).find('td:eq(3)').attr("id");
            const rumus = $(this).find('td:eq(4)').attr("id");
            const amount = $(this).find('input[name="amount"]').val()?.replace(/\,/g,"").trim() || "";
           
            data.push({
                msID: msID,
                rumus: rumus,
                hitungan: hitungan,
                amount:amount
            });
        });

        return data;
    };


     ambilDataTabelKurdata(selector){
        const data = [];

        $(selector).each(function () {
            const partid        = $(this).find('td:eq(1)').text();
            const partname      = $(this).find('td:eq(2)').text();
            const qty           = $(this).find('td:eq(3)').text().replace(/\,/g,"").trim();
            const unit          = $(this).find('td:eq(4)').text();
            const price         = $(this).find('td:eq(5)').text().replace(/\,/g,"").trim();
            const amount_usd    = $(this).find('td:eq(6)').text().replace(/\,/g,"").trim();
            const kurs          = $(this).find('td:eq(7)').text().replace(/\,/g,"").trim();
            const Hpp_Awal      = $(this).find('td:eq(8)').attr('id').replace(/\,/g,"").trim();
            const amount_rp     = $(this).find('td:eq(9)').text().replace(/\,/g,"").trim();
            const kurs_akhir    = $(this).find('td:eq(10)').attr('id').replace(/\,/g,"").trim();
            const amount_akhir   = $(this).find('td:eq(11)').attr('id').replace(/\,/g,"").trim();
            const Hpp_Akhir     = $(this).find('td:eq(12)').attr('id').replace(/\,/g,"").trim();
            const Selisih_Hpp     = $(this).find('td:eq(13)').attr('id').replace(/\,/g,"").trim();

           

           
            data.push({
                partid   : partid,
                partname : partname,
                qty      : qty,
                unit     : unit,
                price    : price,
                amount_usd: amount_usd,
                kurs     : kurs,
                Hpp_Awal :Hpp_Awal,
                amount_rp :amount_rp,
                kurs_akhir : kurs_akhir,
                amount_akhir:amount_akhir,
                Hpp_Akhir   :Hpp_Akhir,
                Selisih_Hpp :Selisih_Hpp
            
            });
        });

        return data;
    };

    updateData(datas) {
        $.ajax({
            url: `${this.baseUrl}/router/seturl`,
            method: "POST",
            dataType: "json",
            data:JSON.stringify(datas),
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            headers: { url: 'transkur/updatedata' },
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
                    text: "Terjadi kesalahan saat Update data."
                });
            }
        });
    }

    UpdatedataKur() {
        const dataheader = this.getFormData();
        const detailforwader = this.ambilDataTabelForwader("#table_DetailforwaderEdit > tbody > tr");
        const detailkurdata = this.ambilDataTabelKurdata("#table_kurdata > tbody > tr");

        const fullData = {
            dataheader: dataheader,
            detailforwader: detailforwader,
            detailkurdata: detailkurdata
        };
 
        
        this.updateData(fullData);
    }
}

// Cara pemakaian:

export function UpdatedataKur() {
    const kurService = new KurDataService();
    kurService.UpdatedataKur();
}
