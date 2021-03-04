<script>
import { toastrOptions } from "./constants/objects";

export default {
  props: ["sessions", "lang"],
  data: function() {
    return {
      baseUrl,
      admin: "fapesp",
      ready: true,
      total: 0,
      list: [],
      posts: [],
      filters: {
        page: 1,
        key: "",
        daterange: "",
        session_id: "0",
        order: "0"
      },
      errors: []
    };
  },

  methods: {
    getPosts: function() {
      let url = baseUrl + "api/admin/ajax/post-list";
      this.ready = false;
      axios
        .get(url, {
          params: {
            page: this.filters.page,
            daterange: this.filters.daterange,
            key: this.filters.key,
            session_id: this.filters.session_id,
            order: this.filters.order,
            lang: this.lang
          }
        })
        .then(response => {
          this.ready = true;
          this.list = response.data;
          this.posts = this.list.rs.data;
          this.total = this.list.rs.total;
        })
        .catch(error => {
          console.log(
            "Error: " + error.response.status + " / " + error.response.data
          );
        });
    },

    navigate: function(ev, page) {
      this.filters.key = $("#key").val();
      this.filters.page = page;

      if ($("#daterange").val()) {
        this.filters.daterange =
          $('input[name="daterange"]')
            .data("daterangepicker")
            .startDate.format("YYYY-MM-DD") +
          "," +
          $('input[name="daterange"]')
            .data("daterangepicker")
            .endDate.format("YYYY-MM-DD");
      } else {
        this.filters.daterange = "";
      }

      this.getPosts(page);
    },

    _bindFilters: function() {
      $("#cb_order, #cb_session_id").change(e => {
        let $this = e.target;
        let item = $($this)
          .attr("id")
          .replace("cb_", "");
        this.filters[item] = $($this).val();

        $("#btn-submit").click();
      });

      $("#key").on("keypress", e => {
        if (e.which == 13) $("#btn-submit").click();
      });

      $("#btn-submit").on("click", () => {
        if (this.ready) this.navigate(null, 1);
      });
    },

    _bindClearFilters: function() {
      this.filters.key = "";
      $("#key").val("");
      this.filters.daterange = "";
      $("#daterange").val("");
      $("#cb_session_id").select2("val", "0");
      $("#cb_order").select2("val", "0");
      $("#btn-submit").click();
    },

    _bindRedirect: function(url) {
      url = baseUrl + this.admin + (this.lang == "en" ? "-en" : "") + "/" + url;
      window.location.href = url;
    },

    _delete: function(post) {
      let object = this;
      let msg =
        "Confirma, exclusão da matéria? <br><strong>" +
        post.id +
        "</strong> - " +
        post.title;

      $("#modalPage")
        .find(".modal-title")
        .html('<i class="fa fa-fw fa-warning"></i> Alerta!');
      $("#modalPage")
        .find(".modal-body")
        .html(msg);
      $("#modalPage")
        .find(".modal-footer")
        .html(
          '<button type="submit" class="btn btn-default" data-dismiss="modal">Cancelar</button><button type="button" id="bnt-confirm" class="btn btn-danger pull-right">Sim</button>'
        );

      $("#modalPage").modal();

      $("#bnt-confirm").click(function() {
        let data = new FormData();
        data.append("id", post.id);

        let url = baseUrl + "api/admin/ajax/post-del";
        let message = "Deletado com sucesso!";

        axios
          .post(url, data)
          .then(response => {
            let data = response.data;
            toastr.success(message);
            object.getPosts();
          })
          .catch(error => {
            console.log(
              "Error: " + error.response.status + " / " + error.response.data
            );
          });

        $("#modalPage").modal("hide");
      });
    }
  },

  mounted: function() {
    this._bindFilters();
    this.getPosts();
    setTimeout(() => {
      $("#daterange")
        .daterangepicker(
          {
            autoUpdateInput: false,
            opens: "left",
            ranges: {
              "Últimos 7 dias": [moment().subtract(6, "days"), moment()],
              "Últimos 30 dias": [moment().subtract(29, "days"), moment()],
              "Este Mês": [moment().startOf("month"), moment().endOf("month")],
              "Mês Anterior": [
                moment()
                  .subtract(1, "month")
                  .startOf("month"),
                moment()
                  .subtract(1, "month")
                  .endOf("month")
              ]
            },
            locale: {
              format: "DD/MM/YYYY",
              separator: " - ",
              applyLabel: "Aplicar",
              cancelLabel: "Limpar",
              fromLabel: "De",
              toLabel: "Para",
              customRangeLabel: "Personalizado",
              weekLabel: "S",
              daysOfWeek: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"],
              monthNames: [
                "Janeiro",
                "Fevereiro",
                "Março",
                "Abril",
                "Maio",
                "Junho",
                "Julho",
                "Agosto",
                "Setembro",
                "Outubro",
                "Novembro",
                "Dezembro"
              ],
              firstDay: 1
            }
          },
          function(start, end, label) {
            console.log(
              "Uma nova seleção de data foi feita: " +
                start.format("DD-MM-YYYY") +
                " à " +
                end.format("DD-MM-YYYY")
            );
          }
        )
        .on("apply.daterangepicker", function(ev, picker) {
          $("#daterange").val(
            picker.startDate.format("DD/MM/YYYY") +
              " - " +
              picker.endDate.format("DD/MM/YYYY")
          );
          $("#btn-submit").click();
        })
        .on("cancel.daterangepicker", function(ev, picker) {
          $("#daterange").val("");
          $("#btn-submit").click();
        });
    }, 300);
  }
};
</script>

<template>
  <div class="col-xs-12">
    <div>
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">
            <i class="fa fa-files-o"></i>
            <strong>Filtros</strong> Matérias
          </h3>
        </div>
        <div class="box-body">
          <div class="form-group col-md-3">
            <label for="key">Palavra Chave | ID</label>
            <input type="text" class="form-control" id="key" name="key" placeholder="Palavra chave">
          </div>
          <div class="form-group col-md-3">
            <label>Período</label>
            <input
              type="text"
              class="form-control"
              id="daterange"
              name="daterange"
              :value="filters.daterange"
            >
          </div>
          <div class="form-group col-md-3">
            <label for="cb_session_id">Seção</label>
            <select
              class="form-control select2"
              name="cb_session_id"
              id="cb_session_id"
              :value="filters.session_id"
            >
              <option value="0">Todas</option>
              <option
                v-for="session in this.sessions"
                :key="session.id"
                :selected="session.id == filters.session_id"
                :value="session.id"
                v-html="session.description"
              ></option>
            </select>
          </div>
          <div class="form-group col-md-3">
            <label for="cb_register">Ordenação</label>
            <select
              class="form-control select2"
              name="cb_order"
              id="cb_order"
              :value="filters.order"
            >
              <option value="0">Data Decrescente</option>
              <option value="1">Ultimas Editadas</option>
              <option value="2">Data Crescente</option>
            </select>
          </div>
        </div>
        <div class="box-footer">
          <div class="pull-right">
            <button class="btn btn-default" v-on:click="_bindClearFilters">Limpar</button>
            <button class="btn btn-info pull-right" id="btn-submit">Filtrar</button>
          </div>
          <div class="pull-left">
            <button class="btn btn-success" v-on:click="_bindRedirect('materia/nova')">Nova Matéria</button>
          </div>
        </div>
        <div class="box-footer">
          <p class="help-block">Total filtrado :: {{ total }}</p>
        </div>
      </div>
    </div>

    <div class="text-red text-center load" v-if="ready==false">
      <img
        class="loading"
        :src="baseUrl + 'assets/img/loading.svg'"
        style="width: 100%; height: 200px;"
      >
    </div>

    <div v-if="ready==true && posts.length > 0">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">
            <i class="fa fa-files-o"></i>
            <strong>Matérias</strong>
          </h3>
          <div class="pull-right">
            <ul v-if="ready==true" class="pagination pagination-sm no-margin pull-right">
              <li>
                <a href="javascript:;" v-on:click="navigate($event, 1)">&#171;</a>
              </li>
              <li>
                <a
                  href="javascript:;"
                  v-on:click="navigate($event, list.rs.current_page - 1)"
                >&#8249;</a>
              </li>
              <li
                v-for="page in list.rangePages"
                :key="page"
                :class="{active: list.rs.current_page == page}"
              >
                <a href="javascript:;" v-on:click="navigate($event, page)">{{ page }}</a>
              </li>
              <li>
                <a
                  href="javascript:;"
                  v-on:click="navigate($event, list.rs.current_page + 1)"
                >&#8250;</a>
              </li>
              <li>
                <a href="javascript:;" v-on:click="navigate($event, list.rs.last_page)">&#187;</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="box-body table-responsive no-padding">
          <table class="table table-hover">
            <tbody>
              <tr>
                <th>Id</th>
                <th>Título</th>
                <th>Seção</th>
                <th>Data</th>
                <th>Ações</th>
              </tr>
              <tr v-for="post in posts" :key="post.id">
                <td>{{ post.id }}</td>
                <td>{{ post.title }}</td>
                <td>{{ post.session ? post.session.description : '' }}</td>
                <td>{{ post.date }}</td>
                <td>
                  <a
                    href="javascript:;"
                    class="edit col-xs-3"
                    v-on:click="_bindRedirect('materia/' + post.id)"
                  >
                    <i class="fa fa-pencil"></i>
                  </a>
                  <a href="javascript:;" class="edit col-xs-3" v-on:click="_delete(post)">
                    <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
          <!-- <div class="pull-left">
            <button class="btn btn-info btn-multiple" v-on:click="download()">Download</button>
          </div>-->
          <div class="pull-right">
            <ul v-if="ready==true" class="pagination pagination-sm no-margin pull-right">
              <li>
                <a href="javascript:;" v-on:click="navigate($event, 1)">&#171;</a>
              </li>
              <li>
                <a
                  href="javascript:;"
                  v-on:click="navigate($event, list.rs.current_page - 1)"
                >&#8249;</a>
              </li>
              <li
                v-for="page in list.rangePages"
                :key="page"
                :class="{active: list.rs.current_page == page}"
              >
                <a href="javascript:;" v-on:click="navigate($event, page)">{{ page }}</a>
              </li>
              <li>
                <a
                  href="javascript:;"
                  v-on:click="navigate($event, list.rs.current_page + 1)"
                >&#8250;</a>
              </li>
              <li>
                <a href="javascript:;" v-on:click="navigate($event, list.rs.last_page)">&#187;</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped=""></style>
