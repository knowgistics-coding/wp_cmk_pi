<?php

function render_jp_encyclopedia_searchbox($bgImage)
{
  echo '<style>
  .search-wrap-body {
    border: solid 1px #333;
    display: flex;
    background-color: #fff;
  }
  .search-wrap-body input[type=text] {
    flex: 1;
    border: none;
    border-radius: 0;
    background: none;
    text-align: center;
    padding: .5rem;
    line-height: 1;
  }
  .search-wrap-body input[type=text]::placeholder {
    color: var(--hilight-color);
  }
  .search-wrap-body .btn-submit {
    border: none;
    background: none;
    color: var(--hilight-color);
  }
  </style>';
  echo '<div class="cover-contain-md" style="background-image:url(\''.$bgImage.'\')">
    <div class="cover-meta" style="background-color:#faf7e8;padding: 1rem;">
      <h2 style="color:#333;font-family:\'Noto Sans JP\',\'Prompt\';font-weight:bold;">สารานุกรมวัฒนธรรมญี่ปุ่น<br />日本文化百科事典</h2>
      <form class="search-wrap-body" action="/encyclopedia/" method="post">
        <input
          class="form-control"
          type="text"
          name="search"
          placeholder="ค้นหา"
          required
          oninvalid="this.setCustomValidity(\'กรุณากรอกคำค้นหา\')"
        />
        <button class="btn-submit"><i class="fas fa-search"></i></button>
      </form>
    </div>
  </div>';
}