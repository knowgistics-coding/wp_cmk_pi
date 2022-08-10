<?php

function render_jp_encyclopedia_searchbox($bgImage)
{
  echo '<style>
  .encyclopedia-container {
    position: relative;
  }
  .encyclopedia-container:before {
    content: "";
    display: block;
    padding-top: calc(100% / 2);
  }
  .encyclopedia-container .encyclopedia-absolute {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }
  .encyclopedia-absolute h2 {
    color: #333;
    font-family: "Noto Sans JP","Prompt";
    font-size: 48px;
    text-align: center;
  }
  .encyclopedia-content {
    width: 640px;
    max-width: 90%;
  }
  @media screen and (max-width: 768px){
    .encyclopedia-container:before {
      padding-top: calc(100%);
    }
    .encyclopedia-absolute h2 {
      font-size: var(--font-l);
      text-align: center;
    }
  }
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
  echo '<div class="container" style="padding:0 1rem;">
    <div class="encyclopedia-container" style="background-image:url(\''.$bgImage.'\')">
      <div class="encyclopedia-absolute">
        <div class="encyclopedia-content" style="background-color:#faf7e8;padding: 1rem;">
          <h2 style="font-weight:bold;">สารานุกรมวัฒนธรรมญี่ปุ่น</h2>
          <h2>日本文化百科事典</h2>
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
      </div>
    </div>
  </div>';
}