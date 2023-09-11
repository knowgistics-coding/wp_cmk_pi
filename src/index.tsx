import { render } from 'preact'
import React from 'preact/compat'

import { PageDynamic } from './pages/dynamic'
import { DynamicSetting } from './pages/dynamic.setting';

const Home = document.getElementById('rx-home');

if(Home){
  render(<PageDynamic />, Home)
}

// @ts-ignore
globalThis.DynamicSetting = DynamicSetting;