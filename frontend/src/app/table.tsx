import { Students } from "@/fetcher/student";
import React from "react";

export async function StudentTable({ data }: React.PropsWithoutRef<{
  data: Students;
}>) {
  return (
    <table className="ts-table">
      <thead>
        <tr>
          <th>姓名</th>
          <th>地址</th>
          <th>生日</th>
        </tr>
      </thead>
      <tbody>
        {data.map(({ name, address, birth }) => {
          return (
            <tr>
              <td>{name}</td>
              <td>{address}</td>
              <td>{birth.toISOString()}</td>
            </tr>
          );
        })}
        <tr>
          <td>1</td>
          <td>半音商業銀行</td>
          <td>Flat Bank</td>
        </tr>
        <tr>
          <td>2</td>
          <td>對空音商事有限公司</td>
          <td>Sorae & Co., Ltd.</td>
        </tr>
        <tr>
          <td>3</td>
          <td>卡莉絲伊繁星</td>
          <td>Caris Events</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <th colSpan={3}>統計筆數：3</th>
        </tr>
      </tfoot>
    </table>
  );
}
