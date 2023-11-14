"use client";

import { createStudent } from "@/fetcher/student.actions";
import type { StudentActions, StudentRequestDto, Students } from "@/fetcher/student.types";
import { revalidateTag } from "next/cache";
import React, { Dispatch, ReducerAction, useReducer, useState } from "react";

export function StudentTable({ data }: React.PropsWithoutRef<{
  data: Students;
}>) {
  const [showNewArea, setShowNewArea] = useState(false);

  return (
    <table className="ts-table">
      <thead>
        <tr>
          <th>姓名</th>
          <th>地址</th>
          <th>生日</th>
          <th>編輯</th>
        </tr>
      </thead>
      <tbody>
        {data.map((row) => <StudentRow key={JSON.stringify(row)} data={row} />)}
        {showNewArea ? <NewStudentArea /> : null}
      </tbody>
      <tfoot>
        <tr>
          <th colSpan={4}>
            <button
              className="ts-button"
              onClick={() => setShowNewArea(v => !v)}
            >
              新增資料
            </button>
          </th>
        </tr>
      </tfoot>
    </table>
  );
}

function StudentRow({ data }: React.PropsWithoutRef<{ data: StudentActions }>) {
  return (
    <tr>
      <td>{data.name}</td>
      <td>{data.addr}</td>
      <td>{data.birth.toISOString()}</td>
      <td></td>
    </tr>
  );
}

function NewStudentArea() {
  const initializer = {
    name: "",
    addr: "",
    birth: "2000-01-01",
  } satisfies StudentFormState;
  const reducer = useReducer(studentReducer, initializer);
  const [loading, setLoading] = useState(false);

  return (
    <tr>
      <EditableStudentCell k="name" type="text" reducer={reducer} />
      <EditableStudentCell k="addr" type="text" reducer={reducer} />
      <EditableStudentCell k="birth" type="date" reducer={reducer} />
      <td>
        <button
          className="ts-button"
          onClick={async () => {
            setLoading(true);

            const [state, action] = reducer;

            try {
              await createStudent(state);
              action({ "type": "put", "content": initializer });
              location.reload();
            } catch (e) {
              alert("Failed to create student: " + e);
            } finally {
              setLoading(false);
            }
          }}
        >
          {loading ? <div className="ts-loading" /> : "新增"}
        </button>
      </td>
    </tr>
  );
}

function EditableStudentCell(
  { k, type, reducer: [state, action] }: React.PropsWithoutRef<{
    k: keyof StudentFormState;
    type: React.HTMLInputTypeAttribute;
    reducer: [StudentFormState, Dispatch<ReducerAction<typeof studentReducer<keyof StudentRequestDto>>>];
  }>,
) {
  return (
    <td>
      <div className="ts-input">
        <input
          type={type}
          value={state[k]}
          onInput={(event) => {
            action({
              type: "patch",
              key: k,
              value: event.currentTarget.value,
            });
          }}
        />
      </div>
    </td>
  );
}

type StudentFormState = StudentRequestDto;

function studentReducer<K extends keyof StudentFormState>(
  state: StudentFormState,
  action:
    | { "type": "patch"; "key": K; "value": StudentFormState[K] }
    | { "type": "put"; "content": StudentFormState },
): StudentFormState {
  switch (action.type) {
    case "patch":
      return {
        ...state,
        [action.key]: action.value,
      };
    case "put":
      return action.content;
  }
}
