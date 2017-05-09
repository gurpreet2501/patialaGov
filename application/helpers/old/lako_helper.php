<?php

function obj($obj){
  return lib('objects')->get($obj);
}

function lib($lib){
  return lako::get($lib);
}